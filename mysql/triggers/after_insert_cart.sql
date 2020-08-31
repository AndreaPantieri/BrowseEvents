CREATE DEFINER = CURRENT_USER TRIGGER `BrowseEventsDB`.`Cart_AFTER_INSERT` AFTER INSERT ON `Cart` FOR EACH ROW
BEGIN
IF NEW.isAcquired = 1 THEN
		SET @nameEvent = (SELECT Name FROM `event` WHERE idEvent = NEW.Event_idEvent);
		SET @nameUser = (SELECT Username FROM User WHERE idUsers = NEW.User_idUsers);
		SET @emailUser = (SELECT Email FROM User WHERE idUsers = NEW.User_idUsers);
		SET @idOrganizer = (SELECT User_idUsers FROM `event` WHERE idEvent = NEW.Event_idEvent);

		INSERT INTO Notification (Title, Description) VALUE("Tickets bought ", CONCAT(@nameUser, " (email: ", @emailUser, ") has bought ", NEW.TicketQuantity, " tickets for the event ", @nameEvent, " on ", NEW.Date));
		SET @idNotification = (SELECT idNotification FROM Notification ORDER BY idNotification DESC LIMIT 1);

		
        IF @idOrganizer != NEW.User_idUsers THEN
			INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(@idOrganizer, @idNotification);
        END IF;
		INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(NEW.User_idUsers, @idNotification);
	END IF;
END