ALTER TABLE `product_list` ADD `has_attribute` INT NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `attributes` ADD `category_id` INT NULL DEFAULT NULL AFTER `id`;