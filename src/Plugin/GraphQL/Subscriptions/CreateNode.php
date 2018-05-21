<?php

namespace Drupal\graphql_subscription\Plugin\GraphQL\Subscriptions;

use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Subscriptions\SubscriptionPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Create node subscription.
 *
 * @GraphQLSubscription(
 *   id = "create_node_subscription",
 *   secure = true,
 *   name = "createNodeSubscription",
 *   type = "Any!",
 *   arguments = {
 *     "notified_by" = "[String]"
 *   }
 * )
 */
class CreateNode extends SubscriptionPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {}

}
