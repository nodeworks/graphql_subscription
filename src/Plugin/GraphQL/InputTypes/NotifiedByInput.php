<?php

namespace Drupal\graphql_subscription\Plugin\GraphQL\InputTypes;

use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;

/**
 * The input array to subscribe to mutations.
 *
 * @GraphQLInputType(
 *   id = "notified_by_input",
 *   name = "NotifiedBy",
 *   fields = {
 *     "title" = "[String]!"
 *   }
 * )
 */
class NotifiedByInput extends InputTypePluginBase {

}
