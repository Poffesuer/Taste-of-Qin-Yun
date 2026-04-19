-- Run once on an existing `restaurant` database that was created before `is_admin` existed.
-- Default admin: username `admin`, password `password`.

ALTER TABLE `login_details`
  ADD COLUMN `is_admin` tinyint(1) NOT NULL DEFAULT 0 AFTER `password`;

INSERT IGNORE INTO `login_details` (`email`, `username`, `password`, `is_admin`)
VALUES (
  'admin@restaurant.local',
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  1
);
