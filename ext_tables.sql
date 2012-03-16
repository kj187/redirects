#
# Table structure for table 'tx_redirects_domain_model_redirect'
#
CREATE TABLE tx_redirects_domain_model_redirect (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	source_domain int(11) DEFAULT '0' NOT NULL,
	source_path varchar(255) DEFAULT '' NOT NULL,
	force_ssl tinyint(1) unsigned DEFAULT '0' NOT NULL,
	keep_get tinyint(1) unsigned DEFAULT '0' NOT NULL,
	target varchar(255) DEFAULT '' NOT NULL,
	header int(11) DEFAULT '0' NOT NULL,
	exclude_ips varchar(255) DEFAULT '' NOT NULL,
	country_code varchar(255) DEFAULT '' NOT NULL,
	accept_language varchar(255) DEFAULT '' NOT NULL,
	user_agent int(11) DEFAULT '0' NOT NULL,
	count int(11) DEFAULT '0' NOT NULL,
	disable_count tinyint(1) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);