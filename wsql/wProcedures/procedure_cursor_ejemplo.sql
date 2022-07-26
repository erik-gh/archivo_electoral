----------------------------------
drop procedure if exists nestedCursor;

create procedure nestedCursor()
BEGIN   
    DECLARE done1, done2 BOOLEAN DEFAULT FALSE;  
    DECLARE parentId,childId int;
    DECLARE childValue varchar(30);

    DECLARE cur1 CURSOR FOR SELECT a FROM parent;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;

    open cur1;
    loop1: LOOP
    FETCH FROM cur1 INTO parentId;
    IF done1 THEN
        CLOSE cur1;
        LEAVE loop1;
    END IF;

    BLOCK1 : BEGIN
    DECLARE cur2 CURSOR FOR SELECT a,b FROM child where a = parentId;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2 = TRUE;


    open cur2;
    loop2 : LOOP
    FETCH FROM cur2 INTO childId,childValue;  
        if done2 THEN
        CLOSE cur2;
        SET done2 = FALSE;
        LEAVE loop2;
        end if;
        select parentId,childId,childValue;

    END LOOP loop2;
    END BLOCK1;
    END loop loop1;
END;