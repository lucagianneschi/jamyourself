# script per la creazione delle tabelle

CREATE DATABASE `jamdatabase`;

CREATE TABLE `jamdatabase`.`badge` (
  `id` INTEGER,
  `badge` VARCHAR(100)
  INDEX `i_badge_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`jammertype` (
  `id` INTEGER,
  `jammertype` VARCHAR(100)
  INDEX `i_jammertype_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`localtype` (
  `id` INTEGER,
  `localtype` VARCHAR(100)
  INDEX `i_localtype_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`music` (
  `id` INTEGER,
  `music` VARCHAR(100)
  INDEX `i_music_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`playlist` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `fromuser` INTEGER,
  `name` VARCHAR(100),
  `songcounter` INTEGER,
  `unlimited` INTEGER,
  `created` DATETIME,
  `updated` DATETIME,
  INDEX `i_playlist_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`playlist_song` (
  `id_playlist` INTEGER,
  `id_song` INTEGER,
  INDEX `i_playlist_song_id`(`id_playlist`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`song` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `commentcounter` INTEGER,
  `counter` VARCHAR(100),
  `duration` INTEGER,
  `filepath` VARCHAR(100),
  `fromuser` INTEGER,
  `locationlat` LONG,
  `locationlon` LONG,
  `lovecounter` INTEGER,
  `position` INTEGER,
  `record` INTEGER,
  `sharecounter` INTEGER,
  `title` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  INDEX `i_song_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100),
  `password` VARCHAR(100),
  `active` INTEGER,
  `address` VARCHAR(100),
  `background` VARCHAR(100),
  `birthday` DATE,
  `city` VARCHAR(100),
  `collaborationcounter` INTEGER,
  `country` VARCHAR(100),
  `description` VARCHAR(1000),
  `email` VARCHAR(100),
  `facebookid` VARCHAR(100),
  `facebookpage` VARCHAR(100),
  `firstname` VARCHAR(100),
  `followerscounter` INTEGER,
  `followingcounter` INTEGER,
  `friendshipcounter` INTEGER,
  `locationlat` LONG,
  `locationlon` LONG,
  `googlepluspage` VARCHAR(100),
  `jammercounter` INTEGER,
  `jammertype` VARCHAR(100),
  `lang` VARCHAR(2),
  `lastname` VARCHAR(100),
  `level` INTEGER,
  `levelvalue` INTEGER,
  `premium` INTEGER,
  `premiumexpirationdate` DATE,
  `profilepicture` VARCHAR(100),
  `profilethumbnail` VARCHAR(100),
  `sex` VARCHAR(100),
  `twitterpage` VARCHAR(100),
  `type` VARCHAR(100),
  `venuecounter` INTEGER,
  `website` VARCHAR(100),
  `youtubechannel` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  INDEX `i_user_id`(`id`),
  INDEX `i_user_username`(`username`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_badge` (
  `id_user` INTEGER,
  `id_badge` INTEGER
  INDEX `i_user_badge_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_localtype` (
  `id_user` INTEGER,
  `id_localtype` INTEGER
  INDEX `i_user_localtype_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_member` (
  `id_user` INTEGER,
  `id_member` INTEGER
  INDEX `i_user_member_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_music` (
  `id_user` INTEGER,
  `id_music` INTEGER
  INDEX `i_user_music_id`(`id_user`)  
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_video` (
  `id_user` INTEGER,
  `id_video` INTEGER
  INDEX `i_user_video_id`(`id_user`)  
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`video` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `author` VARCHAR(100),
  `counter` VARCHAR(100),
  `description` VARCHAR(1000),
  `duration` INTEGER,
  `fromuser` INTEGER,
  `lovecounter` INTEGER,
  `thumbnail` VARCHAR(100),
  `title` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  INDEX `i_video_id`(`id`)
)
ENGINE = InnoDB;

