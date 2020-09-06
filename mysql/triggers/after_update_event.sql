CREATE DEFINER = CURRENT_USER TRIGGER `BrowseEventsDB`.`Event_AFTER_UPDATE` AFTER UPDATE ON `Event` FOR EACH ROW
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
    DECLARE tmpUser INTEGER DEFAULT 0;

	-- declare cursor for users who bought the event's tickets
	DEClARE curUser
		CURSOR FOR 
			SELECT User_idUsers AS idUser FROM Cart WHERE Event_idEvent = OLD.idEvent AND isAcquired = 1;

	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;

	IF NEW.Place != OLD.Place THEN
		INSERT INTO Notification(Title, Description) VALUES("Place changed", CONCAT("The place has been changed for ", NEW.Name, " to ", NEW.Place));
        SET @idNotification = (SELECT idNotification FROM Notification ORDER BY idNotification DESC LIMIT 1);
        OPEN curUser;
			getUser: LOOP
				FETCH curUser INTO tmpUser;
				IF finished = 1 THEN 
					LEAVE getUser;
				END IF;
				-- insert elements into the table
				INSERT INTO User_has_Notification (User_idUsers, Notification_idNotification) VALUES(tmpUser, @idNotification);
			END LOOP getUser;
		CLOSE curUser;
    END IF;
    IF NEW.Datetime != OLD.Datetime THEN
		INSERT INTO Notification(Title, Description) VALUES("Date changed", CONCAT("The date has been changed for ", NEW.Name, " to ", NEW.Datetime));
        SET @idNotification = (SELECT idNotification FROM Notification ORDER BY idNotification DESC LIMIT 1);
        OPEN curUser;
			getUser: LOOP
				FETCH curUser INTO tmpUser;
				IF finished = 1 THEN 
					LEAVE getUser;
				END IF;
				-- insert elements into the table
				INSERT INTO User_has_Notification (User_idUsers, Notification_idNotification) VALUES(tmpUser, @idNotification);
			END LOOP getUser;
		CLOSE curUser;
    END IF;
     IF NEW.TicketNumber = 0 AND NEW.TicketNumber != OLD.TicketNumber THEN
		INSERT INTO Notification(Title, Description) VALUES("Sold out", CONCAT("All tickets sold for ", NEW.Name));
        SET @idNotification = (SELECT idNotification FROM Notification ORDER BY idNotification DESC LIMIT 1);
        INSERT INTO User_has_Notification (User_idUsers, Notification_idNotification) VALUES(NEW.User_idUsers, @idNotification);
    END IF;
END