<?php

namespace Drupal\cardinal_service_profile\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Deduplicate an array's values, helpful for entity reference fields.
 *
 * @MigrateProcessPlugin(
 *   id = "deduplicate_array",
 *   handle_multiples = TRUE
 * )
 */
class DeduplicateArray extends ProcessPluginBase {

  /**
   * {@inheritDoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (is_array($value)) {
      return array_unique($value);
    }
    return $value;
  }

}
