CREATE TABLE IF NOT EXISTS `otp_verification` (
  `otp_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `otp` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`otp_id`),
  KEY `user_id` (`user_id`)
)
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('inactive','active') DEFAULT 'inactive',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
)