<?php

namespace Drupal\graphql_subscription\Plugin\GraphQL\Subscriptions;

use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Subscriptions\SubscriptionPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * CRUD subscription.
 *
 * @GraphQLSubscription(
 *   id = "crud_subscription",
 *   secure = true,
 *   name = "crudSubscription",
 *   type = "Any!",
 *   arguments = {
 *     "notified_by" = "[String]"
 *   }
 * )
 */
class CrudSubscription extends SubscriptionPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {}

}
