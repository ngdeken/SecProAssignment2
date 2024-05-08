CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255)  NOT NULL,
  `user_email` varchar(255)  NOT NULL,
  `user_password` varchar(255)  NOT NULL,
  `reset_link_token` varchar(255) DEFAULT NULL,
  `exp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `item` varchar(20) NOT NULL,
  `price` int(5) NOT NULL
)

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_list` varchar(200) NOT NULL,
  `order_quantity` varchar(200) NOT NULL,
  `order_total` varchar(7) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `order_time` varchar(40) NOT NULL
) 