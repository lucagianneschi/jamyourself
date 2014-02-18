# script per la creazione delle tabelle

CREATE DATABASE `jamdatabase`;

CREATE TABLE `jamdatabase`.`album` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `commentcounter` INTEGER,
  `counter` INTEGER,
  `cover` VARCHAR(100),
  `description` VARCHAR(1000),
  `fromuser` INTEGER,
  `imagecounter` INTEGER,
  `latitude` LONG,
  `longitude` LONG,
  `lovecounter` INTEGER,
  `sharecounter` INTEGER,
  `thumbnail` VARCHAR(100),
  `title` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_album_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`album_tag` (
  `id` INTEGER,
  `tag` VARCHAR(100),
  INDEX `i_album_tag_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`badge` (
  `id` INTEGER,
  `badge` VARCHAR(100),
  INDEX `i_badge_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`comment` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `album` INTEGER,
  `comment` INTEGER,
  `commentcounter` INTEGER,
  `counter` INTEGER,
  `event` INTEGER,
  `fromuser` INTEGER,
  `image` INTEGER,
  `latitude` LONG,
  `longitude` LONG,
  `lovecounter` INTEGER,
  `record` INTEGER,
  `song` INTEGER,
  `sharecounter` INTEGER,
  `title` VARCHAR(100),
  `text` VARCHAR(100),
  `touser` INTEGER,
  `type` VARCHAR(2),
  `vote` INTEGER,
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_comment_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`comment_tag` (
  `id` INTEGER,
  `tag` VARCHAR(100),
  INDEX `i_comment_tag_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`event` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `address` VARCHAR(100),
  `attendeecounter` INTEGER,
  `cancelledcounter` INTEGER,
  `city` VARCHAR(100),
  `commentcounter` INTEGER,
  `counter` INTEGER,
  `cover` VARCHAR(100),
  `description` VARCHAR(1000),
  `eventdate` DATETIME,
  `fromuser` INTEGER,
  `invitedcounter` INTEGER,
  `latitude` LONG,
  `longitude` LONG,
  `locationname` VARCHAR(100),
  `lovecounter` INTEGER,
  `refusedcounter` INTEGER,
  `reviewcounter` INTEGER,
  `sharecounter` INTEGER,
  `thumbnail` VARCHAR(100),
  `title` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_event_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`event_tag` (
  `id` INTEGER,
  `tag` VARCHAR(100),
  INDEX `i_event_tag_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`image` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `album` INTEGER,
  `commentcounter` INTEGER,
  `counter` INTEGER,
  `description` VARCHAR(1000),
  `fromuser` INTEGER,
  `latitude` LONG,
  `longitude` LONG,
  `lovecounter` INTEGER,
  `path` VARCHAR(100),
  `sharecounter` INTEGER,
  `thumbnail` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_image_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`image_tag` (
  `id` INTEGER,
  `tag` VARCHAR(100),
  INDEX `i_image_tag_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`jammertype` (
  `id` INTEGER,
  `jammertype` VARCHAR(100),
  INDEX `i_jammertype_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`localtype` (
  `id` INTEGER,
  `localtype` VARCHAR(100),
  INDEX `i_localtype_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`music` (
  `id` INTEGER,
  `music` VARCHAR(100),
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
  UNIQUE INDEX `i_playlist_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`record` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `active` INTEGER,
  `buylink` VARCHAR(100),
  `city` VARCHAR(100),
  `commentcounter` INTEGER,
  `counter` INTEGER,
  `cover` VARCHAR(100),
  `description` VARCHAR(1000),
  `duration` INTEGER,
  `fromuser` INTEGER,
  `label` VARCHAR(100),
  `latitude` LONG,
  `longitude` LONG,
  `lovecounter` INTEGER,
  `reviewcounter` INTEGER,
  `sharecounter` INTEGER,
  `songcounter` INTEGER,
  `thumbnail` VARCHAR(100),
  `title` VARCHAR(100),
  `year` INTEGER,
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_record_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`record_genre` (
  `id_record` INTEGER,
  `id_genre` INTEGER,
  INDEX `i_record_genre_id`(`id_record`)
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
  `counter` INTEGER,
  `duration` INTEGER,
  `fromuser` INTEGER,
  `latitude` LONG,
  `longitude` LONG,
  `lovecounter` INTEGER,
  `path` VARCHAR(100),
  `position` INTEGER,
  `record` INTEGER,
  `sharecounter` INTEGER,
  `title` VARCHAR(100),
  `created` DATETIME,
  `updated` DATETIME,
  UNIQUE INDEX `i_song_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`song_genre` (
  `id_song` INTEGER,
  `id_genre` INTEGER,
  INDEX `i_song_genre_id`(`id_song`)
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
  `latitude` LONG,
  `longitude` LONG,
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
  UNIQUE INDEX `i_user_id`(`id`),
  UNIQUE INDEX `i_user_username`(`username`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_album` (
  `id_user` INTEGER,
  `id_album` INTEGER,
  INDEX `i_user_album_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_badge` (
  `id_user` INTEGER,
  `id_badge` INTEGER,
  INDEX `i_user_badge_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_event` (
  `id_user` INTEGER,
  `id_event` INTEGER,
  INDEX `i_user_event_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_image` (
  `id_user` INTEGER,
  `id_image` INTEGER,
  INDEX `i_user_image_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_localtype` (
  `id_user` INTEGER,
  `id_localtype` INTEGER,
  INDEX `i_user_localtype_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_member` (
  `id_user` INTEGER,
  `id_member` INTEGER,
  INDEX `i_user_member_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_music` (
  `id_user` INTEGER,
  `id_music` INTEGER,
  INDEX `i_user_music_id`(`id_user`)  
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_playlist` (
  `id_user` INTEGER,
  `id_playlist` INTEGER,
  INDEX `i_user_playlist_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_record` (
  `id_user` INTEGER,
  `id_record` INTEGER,
  INDEX `i_user_record_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_song` (
  `id_user` INTEGER,
  `id_song` INTEGER,
  INDEX `i_user_song_id`(`id_user`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`user_video` (
  `id_user` INTEGER,
  `id_video` INTEGER,
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
  UNIQUE INDEX `i_video_id`(`id`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`video_genre` (
  `id_video` INTEGER,
  `id_genre` INTEGER,
  INDEX `i_video_genre_id`(`id_video`)
)
ENGINE = InnoDB;

CREATE TABLE `jamdatabase`.`video_tag` (
  `id` INTEGER,
  `tag` VARCHAR(100),
  INDEX `i_video_tag_id`(`id`)
)
ENGINE = InnoDB;