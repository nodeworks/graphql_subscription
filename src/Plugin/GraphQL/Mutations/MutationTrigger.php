<?php

namespace Drupal\graphql_subscription\Plugin\GraphQL\Mutations;

use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql_core\Plugin\GraphQL\Mutations\Entity\CreateEntityBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Simple mutation for creating a new article node.
 *
 * @GraphQLMutation(
 *   id = "mutation_trigger",
 *   secure = true,
 *   name = "mutationTrigger",
 *   type = "Boolean",
 *   arguments = {
 *     "mutation" = "String!",
 *     "data" = "String!",
 *     "return_type" = "String"
 *   }
 * )
 */
class MutationTrigger extends CreateEntityBase {

  /**
   * {@inheritdoc}
   */
  protected function extractEntityInput($value, array $args, ResolveContext $context, ResolveInfo $info) {
    return TRUE;
  }

  public function resolve($value, array $args, ResolveContext $context, ResolveInfo $info) {
    return TRUE;
  }

}
