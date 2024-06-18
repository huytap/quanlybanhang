ALTER TABLE `product_list` ADD `has_attribute` INT NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `attributes` ADD `category_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `product_list` ADD `unit` INT NULL DEFAULT NULL AFTER `attribute_category`;
ALTER TABLE `category_list` ADD `group_id` INT NULL DEFAULT NULL AFTER `has_print_tem`;