ALTER TABLE tf_users ENGINE = InnoDB;
ALTER TABLE tf_contacts ENGINE = InnoDB;
ALTER TABLE tf_groups ENGINE = InnoDB;
ALTER TABLE tf_locations ENGINE = InnoDB;
ALTER TABLE tf_facilities ENGINE = InnoDB;
ALTER TABLE tf_items_related_forms ENGINE = InnoDB;
ALTER TABLE tf_items_related_users ENGINE = InnoDB;

ALTER TABLE tf_files ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS  tf_position(
	position_cd VARCHAR(50),
	position_value VARCHAR(50),
	position_order INT(3),
	PRIMARY KEY (position_cd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tf_title (
	title_cd VARCHAR(20) NOT NULL,
	title_value VARCHAR(50),
	PRIMARY KEY (title_cd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE tf_contacts MODIFY COLUMN title VARCHAR(10) NULL;
UPDATE tf_contacts SET title = NULL WHERE title = '';
UPDATE tf_contacts SET title = REPLACE(LOWER(TRIM(title)),' ', '-') WHERE title = NULL;
INSERT INTO tf_title (SELECT DISTINCT LOWER(REPLACE(REPLACE(title,' ', '-'), '.', '')) as title_cd, title as title_value FROM tf_contacts WHERE title != NULL);

ALTER TABLE tf_contacts MODIFY COLUMN position VARCHAR(50) NULL;

INSERT INTO tf_position SELECT DISTINCT REPLACE(LOWER(TRIM(position)),' ', '-'), position, 1 FROM tf_contacts WHERE position != '';

UPDATE tf_contacts SET position = REPLACE(LOWER(TRIM(position)),' ', '-') WHERE position != '';
UPDATE tf_contacts SET position = NULL WHERE position = '';
ALTER TABLE tf_contacts ADD CONSTRAINT `position_fk` FOREIGN KEY (`position`) REFERENCES `tf_position` (`position_cd`);

ALTER TABLE tf_groups MODIFY COLUMN group_id INT;
ALTER TABLE tf_users MODIFY COLUMN contact_id INT;
ALTER TABLE tf_users MODIFY COLUMN location_id INT NULL;
ALTER TABLE tf_users MODIFY COLUMN group_id INT;
ALTER TABLE tf_locations MODIFY COLUMN location_id INT;
ALTER TABLE tf_contacts MODIFY COLUMN contact_id INT;
ALTER TABLE tf_files MODIFY COLUMN file_id INT;

/** Items **/
ALTER TABLE tf_items ENGINE = InnoDB;
ALTER TABLE tf_items MODIFY COLUMN item_image INT;
ALTER TABLE tf_items MODIFY COLUMN item_id INT;
ALTER TABLE tf_items CHANGE COLUMN default_time time_settings VARCHAR(100) NOT NULL;
ALTER TABLE tf_items ADD CONSTRAINT `item_image_fk` FOREIGN KEY(`item_image`) REFERENCES `tf_files`(`file_id`);

/** Items Day/Time settings **/
CREATE TABLE IF NOT EXISTS tf_item_day_time_settings (
	item_id INT NOT NULL,
	day_settings VARCHAR(50),
	time_settings VARCHAR(50),
	CONSTRAINT `tf_item_dt_settings_item_fk` FOREIGN KEY (`item_id`) REFERENCES `tf_items` (`item_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/** Facilities **/
ALTER TABLE tf_facilities MODIFY COLUMN facility_id INT NOT NULL;
ALTER TABLE tf_facilities MODIFY COLUMN location_id INT NULL;

UPDATE tf_facilities SET location_id = NULL WHERE location_id = 0;
ALTER TABLE tf_facilities ADD CONSTRAINT `location_fk1` FOREIGN KEY(`location_id`) REFERENCES `tf_locations`(`location_id`);

/** Items Related Users **/
# SELECT i.item_id FROM tf_items i LEFT JOIN tf_items_related_users u ON u.item_id=i.item_id WHERE u.item_id IS NULL;
# ALTER TABLE tf_items_related_users ADD CONSTRAINT `item_fk2` FOREIGN KEY(`item_id`) REFERENCES `tf_items`(`item_id`);
ALTER TABLE tf_items_related_users ADD CONSTRAINT `contact_fk1` FOREIGN KEY(`contact_id`) REFERENCES `tf_contacts`(`contact_id`);
ALTER TABLE tf_items_related_users MODIFY COLUMN item_id INT NOT NULL;
ALTER TABLE tf_items_related_users MODIFY COLUMN contact_id INT NOT NULL;


/** Categories **/
ALTER TABLE tf_categories ENGINE = InnoDB;
ALTER TABLE tf_categories MODIFY COLUMN cat_id INT NOT NULL;
ALTER TABLE tf_categories MODIFY COLUMN parent_id INT NOT NULL;
ALTER TABLE tf_categories MODIFY COLUMN location_id INT NOT NULL;
ALTER TABLE tf_categories MODIFY COLUMN cat_image INT NULL;
UPDATE tf_categories SET cat_image=NULL WHERE cat_image=0;
ALTER TABLE tf_categories ADD CONSTRAINT `category_parent_fk` FOREIGN KEY(`parent_id`) REFERENCES `tf_categories`(`cat_id`);
ALTER TABLE tf_categories ADD CONSTRAINT `category_location_fk` FOREIGN KEY(`location_id`) REFERENCES `tf_locations`(`location_id`);
ALTER TABLE tf_categories ADD CONSTRAINT `category_image_fk` FOREIGN KEY(`cat_image`) REFERENCES `tf_files`(`file_id`);

/** Item Categories **/
ALTER TABLE tf_item_categories ENGINE = InnoDB;
ALTER TABLE tf_item_categories MODIFY COLUMN item_id INT NOT NULL;
ALTER TABLE tf_item_categories MODIFY COLUMN category_id INT NOT NULL;
DELETE FROM tf_item_categories WHERE item_id NOT IN (SELECT item_id FROM tf_items);
DELETE FROM tf_item_categories WHERE category_id NOT IN (SELECT cat_id FROM tf_categories);
ALTER TABLE tf_item_categories ADD CONSTRAINT `item_category_item_fk` FOREIGN KEY(`item_id`) REFERENCES `tf_items`(`item_id`);
ALTER TABLE tf_item_categories ADD CONSTRAINT `item_category_category_fk` FOREIGN KEY(`category_id`) REFERENCES `tf_categories`(`cat_id`);


/** Items Facilities **/
ALTER TABLE tf_items_related_facilities ENGINE = InnoDB;
ALTER TABLE tf_items_related_facilities MODIFY COLUMN item_id INT NOT NULL;
ALTER TABLE tf_items_related_facilities MODIFY COLUMN facility_id INT NOT NULL;
# ALTER TABLE tf_items_related_facilities ADD CONSTRAINT `item_facilities_item_fk` FOREIGN KEY(`item_id`) REFERENCES `tf_items`(`item_id`);
# ALTER TABLE tf_items_related_facilities ADD CONSTRAINT `item_facilities_facility_fk` FOREIGN KEY(`facility_id`) REFERENCES `tf_facilities`(`facility_id`);

UPDATE tf_users SET location_id = NULL WHERE location_id=0;
UPDATE tf_users SET group_id = NULL WHERE group_id=0;

ALTER TABLE tf_users ADD CONSTRAINT `contact_fk` FOREIGN KEY (`contact_id`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_users ADD CONSTRAINT `location_fk` FOREIGN KEY (`location_id`) REFERENCES `tf_locations` (`location_id`);
ALTER TABLE tf_users ADD CONSTRAINT `group_fk` FOREIGN KEY (`group_id`) REFERENCES `tf_groups` (`group_id`);

/*Forms */
ALTER TABLE tf_forms ENGINE = InnoDB;
ALTER TABLE tf_forms MODIFY COLUMN form_id INT;

/*Fields */
ALTER TABLE tf_fields ENGINE = InnoDB;
ALTER TABLE tf_fields MODIFY COLUMN field_id INT;

/*Form Fields*/
ALTER TABLE tf_form_fields ENGINE = InnoDB;
ALTER TABLE tf_form_fields MODIFY COLUMN form_id INT;
ALTER TABLE tf_form_fields MODIFY COLUMN field_id INT;

/*Package Types*/
ALTER TABLE tf_package_types ENGINE = InnoDB;

/*Packages*/
ALTER TABLE tf_packages ENGINE = InnoDB;
ALTER TABLE tf_packages MODIFY COLUMN package_id INT;

/*Package Items*/
ALTER TABLE tf_package_items ENGINE = InnoDB;
ALTER TABLE tf_package_items MODIFY COLUMN package_id INT;
ALTER TABLE tf_package_items MODIFY COLUMN item_id INT;
ALTER TABLE tf_package_items ADD CONSTRAINT `package_item_package_fk` FOREIGN KEY (`package_id`) REFERENCES `tf_packages` (`package_id`);
ALTER TABLE tf_package_items ADD CONSTRAINT `package_item_item_fk` FOREIGN KEY (`item_id`) REFERENCES `tf_items` (`item_id`);

/*Bookings*/
ALTER TABLE tf_bookings ENGINE = InnoDB;
ALTER TABLE tf_bookings MODIFY COLUMN booking_id INT;
ALTER TABLE tf_bookings MODIFY COLUMN package_id INT NULL;
ALTER TABLE tf_bookings MODIFY COLUMN room_id INT NULL;

UPDATE tf_bookings SET package_id = NULL WHERE package_id = 0;
UPDATE tf_bookings SET room_id = NULL WHERE room_id = 0;

ALTER TABLE tf_bookings ADD CONSTRAINT `booking_package_fk` FOREIGN KEY (`package_id`) REFERENCES `tf_packages` (`package_id`);
ALTER TABLE tf_bookings ADD CONSTRAINT `booking_guest_fk` FOREIGN KEY (`guest_id`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_bookings ADD CONSTRAINT `booking_author_fk` FOREIGN KEY (`author_id`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_bookings ADD CONSTRAINT `booking_room_fk` FOREIGN KEY (`room_id`) REFERENCES `tf_items` (`item_id`);

/*FORM Entries*/
CREATE TABLE tf_form_entries (
entry_id INT NOT NULL AUTO_INCREMENT,
booking_id INT NULL,
form_id INT NOT NULL,
field_id INT NOT NULL,
field_text_value VARCHAR(100),
field_dropdown_value VARCHAR(100),
field_checkboxes_value VARCHAR(100),
PRIMARY KEY(entry_id),
CONSTRAINT form_entries_booking_fk FOREIGN KEY (booking_id) REFERENCES tf_bookings(booking_id),
CONSTRAINT form_entries_form_fk FOREIGN KEY (form_id) REFERENCES tf_forms(form_id),
CONSTRAINT form_entries_field_fk FOREIGN KEY (field_id) REFERENCES tf_fields(field_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/** Booking Items **/
ALTER TABLE tf_booking_items ENGINE = InnoDB;
ALTER TABLE tf_booking_items MODIFY COLUMN booking_item_id INT;
ALTER TABLE tf_booking_items MODIFY COLUMN item_id INT NOT NULL;
ALTER TABLE tf_booking_items MODIFY COLUMN booking_id INT NOT NULL;

DELETE FROM tf_booking_items WHERE item_id NOT IN (SELECT items.item_id FROM tf_items items);

ALTER TABLE tf_booking_items ADD CONSTRAINT `booking_item_item_fk` FOREIGN KEY (`item_id`) REFERENCES `tf_items` (`item_id`);
ALTER TABLE tf_booking_items ADD CONSTRAINT `booking_item_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `tf_bookings` (`booking_id`);
ALTER TABLE tf_booking_items ADD COLUMN amount DECIMAL(10, 2) DEFAULT 0;
UPDATE tf_booking_items booking_items SET amount = (SELECT item.amount FROM tf_items item WHERE booking_items.item_id=item.item_id) * quantity;

/** Booking Events **/
ALTER TABLE tf_booking_events ENGINE = InnoDB;

ALTER TABLE tf_booking_events MODIFY COLUMN event_id INT;
ALTER TABLE tf_booking_events MODIFY COLUMN facility_id INT;
ALTER TABLE tf_booking_events MODIFY COLUMN author_id INT;
ALTER TABLE tf_booking_events MODIFY COLUMN called_by INT;
ALTER TABLE tf_booking_events MODIFY COLUMN cancelled_by INT;
ALTER TABLE tf_booking_events MODIFY COLUMN deleted_by INT;
ALTER TABLE tf_booking_events MODIFY COLUMN item_id INT;
ALTER TABLE tf_booking_events MODIFY COLUMN booking_item_id INT;

UPDATE tf_booking_events SET facility_id=NULL WHERE facility_id=0;
UPDATE tf_booking_events SET author_id=NULL WHERE author_id=0;
UPDATE tf_booking_events SET called_by=NULL WHERE called_by=0;
UPDATE tf_booking_events SET cancelled_by=NULL WHERE cancelled_by=0;
UPDATE tf_booking_events SET deleted_by=NULL WHERE deleted_by=0;
UPDATE tf_booking_events SET item_id=NULL WHERE item_id=0;
UPDATE tf_booking_events SET booking_item_id=NULL WHERE booking_item_id=0 OR booking_item_id NOT IN (SELECT booking_item_id FROM tf_booking_items);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_facility_fk` FOREIGN KEY (`facility_id`) REFERENCES `tf_facilities` (`facility_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_author_fk` FOREIGN KEY (`author_id`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_called_by_fk` FOREIGN KEY (`called_by`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_cancelled_by_fk` FOREIGN KEY (`cancelled_by`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_deleted_by_fk` FOREIGN KEY (`deleted_by`) REFERENCES `tf_contacts` (`contact_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_item_by_fk` FOREIGN KEY (`item_id`) REFERENCES `tf_items` (`item_id`);
ALTER TABLE tf_booking_events ADD CONSTRAINT `booking_event_booking_item_by_fk` FOREIGN KEY (`booking_item_id`) REFERENCES `tf_booking_items` (`booking_item_id`);

UPDATE tf_booking_events events SET item_id=(SELECT booking_items.item_id FROM tf_booking_items booking_items WHERE events.booking_item_id=booking_items.booking_item_id);

/**Booking Event Users **/
ALTER TABLE tf_booking_event_users ENGINE = InnoDB;

ALTER TABLE tf_booking_event_users MODIFY COLUMN event_id INT;
ALTER TABLE tf_booking_event_users MODIFY COLUMN staff_id INT;
DELETE FROM tf_booking_event_users WHERE staff_id = 0;

ALTER TABLE tf_booking_event_users ADD CONSTRAINT `booking_event_user_event_fk` FOREIGN KEY (`event_id`) REFERENCES `tf_booking_events` (`event_id`);
ALTER TABLE tf_booking_event_users ADD CONSTRAINT `booking_event_user_user_fk` FOREIGN KEY (`staff_id`) REFERENCES `tf_contacts` (`contact_id`);

/**Booking Attachments **/
ALTER TABLE tf_booking_attachments ENGINE = InnoDB;

ALTER TABLE tf_booking_attachments MODIFY COLUMN booking_id INT;
ALTER TABLE tf_booking_attachments MODIFY COLUMN file_id INT;

ALTER TABLE tf_booking_attachments ADD CONSTRAINT `booking_attachment_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `tf_bookings` (`booking_id`);
ALTER TABLE tf_booking_attachments ADD CONSTRAINT `booking_attachment_file_fk` FOREIGN KEY (`file_id`) REFERENCES `tf_files` (`file_id`);

ALTER TABLE tf_booking_events ADD COLUMN incl_os_done_number VARCHAR(20) NULL;
ALTER TABLE tf_booking_events ADD COLUMN incl_os_done_amount DECIMAL(10, 2) NOT NULL;
ALTER TABLE tf_booking_events ADD COLUMN foc_os_done_number VARCHAR(20) NULL;
ALTER TABLE tf_booking_events ADD COLUMN foc_os_done_amount DECIMAL(10, 2) NOT NULL;
ALTER TABLE tf_booking_events ADD COLUMN not_incl_os_done_number VARCHAR(20) NULL;
ALTER TABLE tf_booking_events ADD COLUMN not_incl_os_done_amount DECIMAL(10, 2) NOT NULL;
ALTER TABLE tf_booking_events MODIFY COLUMN start_dt DATETIME NULL;
ALTER TABLE tf_booking_events MODIFY COLUMN end_dt DATETIME NULL;