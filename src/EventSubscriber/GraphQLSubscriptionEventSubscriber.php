<?php

/**
 * @file
 * Contains \Drupal\graphql_subscription\EventSubscriber\GraphQLSubscriptionEventSubscriber.
 */

namespace Drupal\graphql_subscription\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber for GraphQL Subscriptions.
 */
class GraphQLSubscriptionEventSubscriber implements EventSubscriberInterface {

  /**
   * Code that should be triggered on event specified
   */
  public function onRespond(FilterResponseEvent $event) {
    try {
      $response = $event->getResponse();
      $request = $event->getRequest();
      $graphql = $request->attributes->get('_graphql');

      /** @var \Drupal\graphql\Plugin\MutationPluginManager $types */
      $types = \Drupal::service('plugin.manager.graphql.type')->getDefinitions();

      if ($graphql) {
        $port = 4000;
        if (getenv('GRAPHQL_SUBSCRIPTION_PORT')) {
          $port = getenv('GRAPHQL_SUBSCRIPTION_PORT');
        }

        $request_data = $request->getContent();
        $decoded_request_data = json_decode($request_data);
        $decoded_request_query = json_decode($decoded_request_data->query);
        $response_data = $response->getContent();
        $decoded_data = json_decode($response_data);
        $op_array = (array) $decoded_data->data;
        $operation = array_keys($op_array);

        /** @var \Drupal\graphql\Plugin\MutationPluginManager $mutation */
        $mutation = \Drupal::service('plugin.manager.graphql.mutation');
        $mutation_def = $mutation->getDefinitions();

        $mutation_plugin = FALSE;
        $entity_type = FALSE;
        $entity_bundle = FALSE;
        $return_type = FALSE;
        foreach ($mutation_def as $mutation_definition) {
          if ($mutation_definition['name'] === $operation[0]) {
            $mutation_plugin = $mutation_definition;
            $entity_type = $mutation_definition['entity_type'];
            if (isset($mutation_definition['entity_bundle'])) {
              $entity_bundle = $mutation_definition['entity_bundle'];
            }

            break;
          }
        }

        if ($mutation_plugin) {
          foreach ($types as $type) {
            if (isset($type['entity_type'])) {
              if (isset($entity_bundle)) {
                if ($type['entity_type'] === $entity_type && $type['entity_bundle'] === $entity_bundle) {
                  $return_type = $type['name'];
                }
              }
              else {
                if ($type['entity_type'] === $entity_type) {
                  $return_type = $type['name'];
                }
              }
            }
          }
        }

        $client = new \GuzzleHttp\Client();
        $body = '{"query":"mutation {\n  mutationTrigger(return_type: \"' . $return_type . '\", mutation: \"' . $operation[0] . '\", data: \"' . urlencode($response_data) . '\")\n}","variables":null}';
        $client->post('http://localhost:' . $port . '/graphql', [
          'headers' => [
            'Content-Type' => 'application/json',
          ],
          'body' => $body,
        ]);
      }
    }
    catch (\Exception $e) {
      // Do nothing.
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['onRespond'];
    return $events;
  }

}
