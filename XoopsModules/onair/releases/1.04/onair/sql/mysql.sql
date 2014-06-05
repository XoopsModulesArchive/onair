CREATE TABLE oa_program (
oa_id int(5) unsigned NOT NULL auto_increment,
oa_name varchar(50) NOT NULL default '',
oa_station varchar(50) NOT NULL default '',
oa_title varchar(50) NOT NULL default '',
oa_day varchar(18) NOT NULL default '',
oa_start varchar(15) NOT NULL default '',
oa_stop varchar(15) NOT NULL default '',
oa_image text NOT NULL,
oa_description text NOT NULL,
oa_plugin varchar(50) NOT NULL default '',
oa_stream varchar(75) NOT NULL default '',
PRIMARY KEY (oa_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE oa_playlist (
pl_id int(5) unsigned NOT NULL auto_increment,
pl_station varchar(50) NOT NULL default '',
pl_title varchar(50) NOT NULL default '',
pl_day varchar(50) NOT NULL default '',
pl_start varchar(20) NOT NULL default '',
pl_stop varchar(20) NOT NULL default '',
pl_image text NOT NULL,
pl_description text NOT NULL,
pl_name text NOT NULL,
pl_date DATE NOT NULL,
PRIMARY KEY (pl_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE oa_hitlist (
  oa_songid int(10) unsigned NOT NULL auto_increment,
  oa_songsong varchar(50) NOT NULL default '',
  oa_songtime varchar(100) NOT NULL default '',
  oa_songday varchar(1) NOT NULL,
  oa_songweek varchar(2) NOT NULL default '',
  oa_songyear varchar(4) NOT NULL default '',
  PRIMARY KEY  (oa_songid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

CREATE TABLE oa_charts (
  ch_songid int(10) unsigned NOT NULL auto_increment,
  ch_songsong varchar(200) NOT NULL default '',
  ch_songweekstotal varchar(3) NOT NULL default '',
  ch_songlastweek varchar(3) NOT NULL,
  ch_songtopplace varchar(3) NOT NULL default '',
  ch_songthisweek varchar(3) NOT NULL default'',
  ch_songweek varchar(2) NOT NULL default '',
  ch_songplaytime varchar(8) NOT NULL default '',
  PRIMARY KEY  (ch_songid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;