Update religion set status='INACTIVE' where id='4';
Update religion set status='INACTIVE' where id='5';
Update religion set status='INACTIVE' where id='6';
Update religion set status='INACTIVE' where id='7';

ALTER TABLE `constituent` CHANGE `vote_type` `volunteer_status` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


ALTER TABLE `meeting_request` CHANGE `meeting_date` `meeting_date` VARCHAR(20) NOT NULL;



CREATE TABLE `festival_master` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `religion_id` int(11) NOT NULL,
  `festival_name` varchar(80) NOT NULL,
  `status` varchar(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `festival_wishes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `constituent_id` int(11) NOT NULL,
  `festival_id` int(11) NOT NULL,
  `sent_status` varchar(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `constituent_video` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `constituent_id` int(11) NOT NULL,
  `video_title` varchar(40) NOT NULL,
  `video_link` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `office` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `paguthi_id` int(11) NOT NULL,
  `office_name` varchar(40) NOT NULL,
  `office_short_form` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE `constituent`  ADD `voter_status` VARCHAR(10) NOT NULL  AFTER `voter_id_status`;


ALTER TABLE `constituent`  ADD `office_id` INT NOT NULL  AFTER `paguthi_id`;

ALTER TABLE `grievance`  ADD `office_id` INT NOT NULL  AFTER `paguthi_id`;


ALTER TABLE `constituent`  ADD `whatsapp_broadcast` VARCHAR(5) NOT NULL  AFTER `whatsapp_no`;


ALTER TABLE `grievance_reply`  ADD `sms_flag` VARCHAR(10) NOT NULL  AFTER `id`;



ALTER TABLE `constituent`  ADD `created_office_id` INT NOT NULL  AFTER `created_at`;
ALTER TABLE `user_master`  ADD `office_id` INT NOT NULL  AFTER `pugathi_id`;
ALTER TABLE `meeting_request`  ADD `created_office_id` INT NOT NULL  AFTER `created_at`;
ALTER TABLE `constituent_video`  ADD `created_office_id` INT NOT NULL  AFTER `updated_by`;
ALTER TABLE `grievance`  ADD `created_office_id` INT NOT NULL  AFTER `created_at`;
ALTER TABLE `festival_wishes`  ADD `created_office_id` INT NOT NULL  AFTER `updated_by`;
ALTER TABLE `consitutent_birthday_wish` ADD `created_office_id` INT NOT NULL AFTER `created_by`;



ALTER TABLE `grievance`  ADD `constituency_id` INT NOT NULL  AFTER `grievance_type`;
