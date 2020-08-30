CREATE DEFINER = CURRENT_USER TRIGGER `BrowseEventsDB`.`Cart_AFTER_UPDATE` AFTER UPDATE ON `Cart` FOR EACH ROW
BEGIN
	DECLARE nameEvent VARCHAR(255);
	DECLARE nameUser VARCHAR(255);
	DECLARE emailUser VARCHAR(255);
	DECLARE idNotification INT;
	DECLARE idOrganizer INT;
	IF NEW.isAcquired = 1 THEN
		

		SET nameEvent = (SELECT Name FROM `event` WHERE idEvent = NEW.Event_idEvent);
		SET nameUser = (SELECT Username FROM User WHERE idUsers = NEW.User_idUsers);
		SET emailUser = (SELECT Email FROM User WHERE idUsers = NEW.User_idUsers);
		SET idOrganizer = (SELECT User_idUsers FROM `event` WHERE idEvent = NEW.Event_idEvent);

		INSERT INTO Notification (Title, Description) VALUE("Tickets bought ", CONCAT(nameUser, " (email: ", emailUser, ") has bought ", NEW.TicketQuantity, " tickets for the event ", nameEvent, " on ", NEW.Date));
		SET idNotification = (SELECT LAST_INSERT_ID() FROM Notification);

		INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUE(idOrganizer, idNotification);
		INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUE(NEW.User_idUsers, idNotification);
	END IF;
END