ALTER TABLE allpay_trans ADD COLUMN md5_req varchar(255) default NULL;
ALTER TABLE allpay_trans ADD COLUMN order_id varchar(255) default NULL;
ALTER TABLE allpay_trans ADD COLUMN remote_addres varchar(255) default NULL;
ALTER TABLE allpay_trans ADD COLUMN date_time timestamp NOT NULL default
CURRENT_TIMESTAMP;
ALTER TABLE allpay_trans DROP INDEX t_id;
