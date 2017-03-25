-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 28 2010 г., 22:31
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ladder`
--

-- --------------------------------------------------------

--
-- Структура таблицы `webl_cron_log`
--

CREATE TABLE IF NOT EXISTS `webl_cron_log` (
  `Cron` varchar(100) NOT NULL,
  `Time` datetime NOT NULL default '0000-00-00 00:00:00',
  `Message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_cron_log_2`
--

CREATE TABLE IF NOT EXISTS `webl_cron_log_2` (
  `Cron` varchar(100) NOT NULL,
  `Time` datetime NOT NULL default '0000-00-00 00:00:00',
  `Message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_games`
--

CREATE TABLE IF NOT EXISTS `webl_games` (
  `winner` varchar(40) default NULL,
  `loser` varchar(40) default NULL,
  `reported_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `contested_by_loser` int(11) default '0',
  `draw` int(11) default '0',
  `withdrawn` int(11) default '0',
  `winner_elo` int(11) default NULL,
  `winner_points` int(11) default NULL,
  `winner_wins` int(11) default NULL,
  `winner_losses` int(11) default NULL,
  `winner_games` int(11) default NULL,
  `winner_streak` int(11) default NULL,
  `loser_elo` int(11) default NULL,
  `loser_points` int(11) default NULL,
  `loser_wins` int(11) default NULL,
  `loser_losses` int(11) default NULL,
  `loser_games` int(11) default NULL,
  `loser_streak` int(11) default NULL,
  `replay_downloads` int(11) NOT NULL default '0',
  `winner_comment` varchar(500) character set utf8 collate utf8_swedish_ci NOT NULL,
  `loser_comment` varchar(500) character set utf8 collate utf8_swedish_ci NOT NULL,
  `winner_stars` tinyint(1) default NULL COMMENT 'Sportsmanship given by loser',
  `loser_stars` tinyint(1) default NULL COMMENT 'Sportsmanship given by winner',
  `replay_filename` varchar(20) default NULL,
  `w_rank` int(11) NOT NULL,
  `l_rank` int(11) NOT NULL,
  `l_new_rank` int(11) NOT NULL,
  `w_new_rank` int(11) NOT NULL,
  PRIMARY KEY  (`reported_on`),
  KEY `games_winner` (`winner`),
  KEY `games_loser` (`loser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_games_2`
--

CREATE TABLE IF NOT EXISTS `webl_games_2` (
  `winner` varchar(40) default NULL,
  `loser` varchar(40) default NULL,
  `reported_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `contested_by_loser` int(11) default '0',
  `draw` int(11) default '0',
  `withdrawn` int(11) default '0',
  `winner_elo` int(11) default NULL,
  `winner_points` int(11) default NULL,
  `winner_wins` int(11) default NULL,
  `winner_losses` int(11) default NULL,
  `winner_games` int(11) default NULL,
  `winner_streak` int(11) default NULL,
  `loser_elo` int(11) default NULL,
  `loser_points` int(11) default NULL,
  `loser_wins` int(11) default NULL,
  `loser_losses` int(11) default NULL,
  `loser_games` int(11) default NULL,
  `loser_streak` int(11) default NULL,
  `replay_downloads` int(11) NOT NULL default '0',
  `winner_comment` varchar(500) character set utf8 collate utf8_swedish_ci NOT NULL,
  `loser_comment` varchar(500) character set utf8 collate utf8_swedish_ci NOT NULL,
  `winner_stars` tinyint(1) default NULL COMMENT 'Sportsmanship given by loser',
  `loser_stars` tinyint(1) default NULL COMMENT 'Sportsmanship given by winner',
  `replay_filename` varchar(20) default NULL,
  `w_rank` int(11) NOT NULL,
  `l_rank` int(11) NOT NULL,
  `l_new_rank` int(11) NOT NULL,
  `w_new_rank` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_module_message`
--

CREATE TABLE IF NOT EXISTS `webl_module_message` (
  `id` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  `topic_id` int(11) NOT NULL COMMENT 'Refference to topic',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Message' AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_module_topic`
--

CREATE TABLE IF NOT EXISTS `webl_module_topic` (
  `id` int(11) NOT NULL auto_increment,
  `topic` varchar(64) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `deleted_by_sender` tinyint(4) NOT NULL default '0',
  `deleted_by_reciever` tinyint(4) NOT NULL default '0',
  `sent_date` int(11) NOT NULL,
  `read_date` int(11) NOT NULL,
  `signature` varchar(1) NOT NULL default 'u' COMMENT 'Message signature. Can be: u - user, a - admin. s - system, w - warning. u is default.',
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `topic` (`topic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_module_tournament`
--

CREATE TABLE IF NOT EXISTS `webl_module_tournament` (
  `id` int(11) NOT NULL auto_increment,
  `type` smallint(1) NOT NULL default '0' COMMENT '0 - is circular system, 1 - is knock out system',
  `name` varchar(255) NOT NULL,
  `information` text NOT NULL,
  `rules` text NOT NULL,
  `min_participants` int(11) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `games_to_play` int(11) NOT NULL,
  `sign_up_starts` int(11) NOT NULL,
  `sign_up_ends` int(11) NOT NULL,
  `play_starts` int(11) NOT NULL,
  `play_ends` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_module_tournament_filter`
--

CREATE TABLE IF NOT EXISTS `webl_module_tournament_filter` (
  `id` int(11) NOT NULL auto_increment,
  `table_name` varchar(50) NOT NULL default 'players' COMMENT 'Table name without prefix',
  `operator` varchar(2) NOT NULL default '=',
  `field` varchar(30) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_module_tournament_table`
--

CREATE TABLE IF NOT EXISTS `webl_module_tournament_table` (
  `id` int(11) NOT NULL auto_increment,
  `played_games` tinyint(4) NOT NULL default '0',
  `stage` int(11) NOT NULL default '0',
  `current` tinyint(1) NOT NULL default '0' COMMENT 'Is stage current',
  `first_participant` int(11) NOT NULL,
  `second_participant` int(11) NOT NULL,
  `first_result` tinyint(1) NOT NULL default '0',
  `second_result` tinyint(1) NOT NULL default '0',
  `tournament_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_news`
--

CREATE TABLE IF NOT EXISTS `webl_news` (
  `news_id` int(10) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `date` varchar(100) default NULL,
  `news` text,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_news_2`
--

CREATE TABLE IF NOT EXISTS `webl_news_2` (
  `news_id` int(10) NOT NULL default '0',
  `title` varchar(100) default NULL,
  `date` varchar(100) default NULL,
  `news` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_players`
--

CREATE TABLE IF NOT EXISTS `webl_players` (
  `player_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `passworddb` varchar(255) default NULL,
  `approved` varchar(10) default 'no',
  `mail` varchar(50) default NULL,
  `Jabber` varchar(40) default NULL,
  `icq` varchar(15) default NULL,
  `aim` varchar(40) default NULL,
  `msn` varchar(100) default NULL,
  `country` varchar(40) default NULL,
  `ip` varchar(100) default NULL,
  `Avatar` varchar(100) default 'No avatar',
  `HaveVersion` varchar(40) default NULL,
  `MsgMe` char(3) NOT NULL default 'Yes',
  `CanPlay` text,
  `Confirmation` text NOT NULL,
  `question` text COMMENT 'The secret question for password retrieval',
  `answer` text COMMENT 'answer to the secret question',
  `Joined` int(10) default NULL,
  `Titles` varchar(160) default NULL COMMENT 'Special People',
  `active` tinyint(1) NOT NULL default '1',
  `is_admin` tinyint(1) default '0',
  PRIMARY KEY  (`player_id`),
  UNIQUE KEY `name` (`name`),
  FULLTEXT KEY `country` (`country`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2527 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_standings_cache`
--

CREATE TABLE IF NOT EXISTS `webl_standings_cache` (
  `name` varchar(255) NOT NULL default '',
  `reported_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `rating` bigint(11) default NULL,
  `wins` bigint(11) default NULL,
  `losses` bigint(11) default NULL,
  `games` bigint(11) default NULL,
  `streak` bigint(11) default NULL,
  `recently_played` bigint(11) NOT NULL default '0' COMMENT '0 if a player hasn''t played >= games within x days that are required to get a ranking. Else it displays number of games within that time span. ',
  `rank` bigint(7) NOT NULL default '0',
  KEY `cache_report_time` (`reported_on`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_standings_cache_2`
--

CREATE TABLE IF NOT EXISTS `webl_standings_cache_2` (
  `name` varchar(255) NOT NULL default '',
  `reported_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `rating` bigint(11) default NULL,
  `wins` bigint(11) default NULL,
  `losses` bigint(11) default NULL,
  `games` bigint(11) default NULL,
  `streak` bigint(11) default NULL,
  `recently_played` bigint(11) NOT NULL default '0' COMMENT '0 if a player hasn''t played >= games within x days that are required to get a ranking. Else it displays number of games within that time span. ',
  `rank` bigint(7) NOT NULL default '0',
  KEY `reported_on` (`reported_on`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_stats`
--

CREATE TABLE IF NOT EXISTS `webl_stats` (
  `Time` datetime NOT NULL default '0000-00-00 00:00:00',
  `Confirmed_Players` bigint(11) NOT NULL,
  `Played_Games` bigint(11) NOT NULL,
  `Games_Today` int(11) NOT NULL,
  `Games_Recent_7` int(11) NOT NULL,
  `Games_Recent_30` int(11) NOT NULL,
  `Ranked_Players` int(11) NOT NULL,
  `Replay_Downloads` int(11) NOT NULL,
  `Games_Rated` int(11) NOT NULL,
  `Avg_Sportsmanship` float(4,3) NOT NULL,
  `Contested_Games` int(11) NOT NULL,
  `Withdrawn_Games` int(11) NOT NULL,
  `Revoked_Games` int(11) NOT NULL,
  `Commented_Games` int(11) NOT NULL,
  KEY `Time` (`Time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_stats_2`
--

CREATE TABLE IF NOT EXISTS `webl_stats_2` (
  `Time` datetime NOT NULL default '0000-00-00 00:00:00',
  `Confirmed_Players` bigint(11) NOT NULL,
  `Played_Games` bigint(11) NOT NULL,
  `Games_Today` int(11) NOT NULL,
  `Games_Recent_7` int(11) NOT NULL,
  `Games_Recent_30` int(11) NOT NULL,
  `Ranked_Players` int(11) NOT NULL,
  `Replay_Downloads` int(11) NOT NULL,
  `Games_Rated` int(11) NOT NULL,
  `Avg_Sportsmanship` float(4,3) NOT NULL,
  `Contested_Games` int(11) NOT NULL,
  `Withdrawn_Games` int(11) NOT NULL,
  `Revoked_Games` int(11) NOT NULL,
  `Commented_Games` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_teams_2`
--

CREATE TABLE IF NOT EXISTS `webl_teams_2` (
  `team_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `approved` varchar(10) default 'no',
  `Avatar` varchar(100) default 'No avatar',
  `Confirmation` text NOT NULL,
  `Joined` int(10) default NULL,
  `Titles` varchar(160) default NULL COMMENT 'Special People',
  `player1` varchar(255) NOT NULL,
  `player2` varchar(255) NOT NULL,
  `player3` varchar(255) NOT NULL,
  PRIMARY KEY  (`team_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_tournament_entity`
--

CREATE TABLE IF NOT EXISTS `webl_tournament_entity` (
  `id` int(11) NOT NULL auto_increment,
  `entity_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `entity_type` smallint(1) NOT NULL default '0' COMMENT '0 - is single player, 1 - is team',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_tournament_filter_xrel`
--

CREATE TABLE IF NOT EXISTS `webl_tournament_filter_xrel` (
  `id` int(11) NOT NULL auto_increment,
  `tournament_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_tournament_game`
--

CREATE TABLE IF NOT EXISTS `webl_tournament_game` (
  `id` int(11) NOT NULL auto_increment,
  `tournament_id` int(11) NOT NULL,
  `game_dt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_tournament_result`
--

CREATE TABLE IF NOT EXISTS `webl_tournament_result` (
  `id` int(11) NOT NULL auto_increment,
  `tournament_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL COMMENT 'is tournament_entity.id',
  `Title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_waiting`
--

CREATE TABLE IF NOT EXISTS `webl_waiting` (
  `id` int(10) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL default '',
  `time` varchar(10) NOT NULL default '',
  `entered` varchar(12) NOT NULL default '',
  `meetingplace` varchar(3) default NULL,
  `rating` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=505 ;

-- --------------------------------------------------------

--
-- Структура таблицы `webl_waiting_2`
--

CREATE TABLE IF NOT EXISTS `webl_waiting_2` (
  `id` int(10) NOT NULL default '0',
  `username` varchar(25) NOT NULL default '',
  `time` varchar(10) NOT NULL default '',
  `entered` varchar(12) NOT NULL default '',
  `meetingplace` varchar(3) default NULL,
  `rating` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
