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


ALTER TABLE `constituent`  ADD `voter_status` VARCHAR(10) NOT NULL  AFTER `voter_id_status`;
