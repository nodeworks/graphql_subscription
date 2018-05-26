import { PubSub, withFilter } from 'graphql-subscriptions';
import Schema from '../schema.json';

const subs = Schema.data.__schema.types.filter(val => val.name === 'SubscriptionRoot');
const subscriptions = {};
subs[0].fields.forEach(item => {
    subscriptions[item.name] = {
        subscribe: withFilter(() => pubsub.asyncIterator(item.name), (payload, variables) => {
            if (variables.notified_by) {
              const exists = variables.notified_by.filter(mutation => mutation === payload.mutation);
              return exists.length > 0
            }

            return false;
        })
    }
});

const pubsub = new PubSub();
export const resolvers = {
    MutationRoot: {
      mutationTrigger: (root, args, context, info) => {
        const returnType = args.return_type || false;
        const data = JSON.parse(decodeURIComponent(args.data));
        const entity = { entity: { ...data.data[args.mutation].entity } };

        Object.keys(subscriptions).forEach(sub => {
          pubsub.publish(sub, {
            mutation: args.mutation,
            [sub]: {
              ...data.data[args.mutation],
              ...entity
            }
          });
        });
      }
    },
    SubscriptionRoot: subscriptions
};
