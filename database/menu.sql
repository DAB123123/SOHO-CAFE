
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `no_order` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `price`, `no_order`) VALUES
(1, 'Espresso', 'Strong and bold espresso shot made from freshly ground beans.', 60, 0),
(2, 'Cappuccino', 'Espresso topped with steamed milk and foam.', 80, 0),
(3, 'Iced Americano', 'Chilled espresso with water over ice.', 75, 0),
(4, 'Café Latte', 'Smooth espresso with steamed milk.', 85, 0),
(5, 'Caramel Macchiato', 'Layered espresso, milk, and caramel drizzle.', 95, 0),
(6, 'Classic Waffles', 'Golden waffles served with maple syrup and butter.', 120, 0),
(7, 'Avocado Toast', 'Toasted sourdough topped with mashed avocado and chili flakes.', 150, 0),
(8, 'Egg Sandwich', 'Scrambled eggs with cheese on a brioche bun.', 110, 0),
(9, 'Croissant', 'Buttery and flaky freshly baked croissant.', 55, 0),
(10, 'Chocolate Muffin', 'Rich chocolate muffin with gooey center.', 60, 0),
(11, 'Blueberry Pancakes', 'Fluffy pancakes topped with fresh blueberries and syrup.', 140, 0),
(12, 'Caesar Salad', 'Crisp romaine with Caesar dressing, croutons, and parmesan.', 130, 0),
(13, 'Chicken Wrap', 'Grilled chicken, veggies, and sauce in a tortilla wrap.', 160, 0),
(14, 'Club Sandwich', 'Triple layered sandwich with ham, cheese, egg, and veggies.', 165, 0),
(15, 'Fruit Smoothie', 'Blended seasonal fruits with yogurt and honey.', 90, 0),
(16, 'Iced Tea', 'Brewed black tea served over ice with lemon.', 60, 0),
(17, 'Hot Chocolate', 'Creamy cocoa topped with whipped cream.', 85, 0),
(18, 'Bottled Water', 'Mineral water (500ml).', 30, 0);
COMMIT;