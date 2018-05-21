import { makeExecutableSchema } from 'graphql-tools';
import { printSchema, buildClientSchema } from 'graphql';
import { resolvers } from './resolvers';
import Schema from '../../../../sites/default/files/schema.json';

const shorthandSchema = buildClientSchema(Schema.data);
const fullSchema = printSchema(shorthandSchema);

const schema = makeExecutableSchema({
  typeDefs: [fullSchema],
  resolvers,
  resolverValidationOptions: {
    requireResolversForResolveType: false
  }
});

export { schema };
