use `car`;

-- ==================================================================================================
-- ==================================================================================================

INSERT INTO `user` (`account`, `password`)
    VALUES ('justplay', 'justplay');


-- ==================================================================================================
-- ==================================================================================================

INSERT INTO `groups` (`name`) VALUES ('草民');
INSERT INTO `groups` (`name`) VALUES ('貴賓');

-- ==================================================================================================
-- ==================================================================================================

INSERT INTO `customer` (`name`,`company`, `vat`, `address`, `phone`,`cellphone`,`cellphone2`, `email`, `created_on`, `group_id`)
    VALUES ('許功蓋', 'TSMC'   ,'12345678' ,'板橋市', '0492902176','0911223344','0911223344', 'abc@123.com', NOW(), 1);

INSERT INTO `customer` (`name`,`company`, `vat`,`address`, `phone`,`cellphone`, `cellphone2`,`email`, `created_on`,`group_id`)
    VALUES ('吳明峰', 'FOXCONN','234567891','新莊市', '0229103333','0933334444','0933334444', 'xyz@456.com', NOW(), 1);

INSERT INTO `customer` (`name`,`company`, `vat`,`address`, `phone`,`cellphone`,`cellphone2`, `email`, `created_on`,`group_id`)
    VALUES ('楊立群', 'HTC'    ,'345678912','Keelung','0229103333','0955556666','0955556666', 'zzz@456.com', NOW(), 2);

-- ==================================================================================================
-- ==================================================================================================


 INSERT INTO `sell_order` ( `paid`, `created_on`, `note`, `customer_id`)
    VALUES ( 0, NOW(), '賣出訂單備註', 1 );


-- ==================================================================================================
-- ==================================================================================================


 INSERT INTO `buy_order` ( `paid`, `created_on`, `note`, `customer_id`)
    VALUES ( 0, NOW(), '買入訂單備註', 1 );

-- ==================================================================================================
-- ==================================================================================================


INSERT INTO `item` (`name`) VALUES ('銅');
INSERT INTO `item` (`name`) VALUES ('銀');
-- ==================================================================================================
-- ==================================================================================================


INSERT INTO `unit` (`name`) VALUES ('噸');
INSERT INTO `unit` (`name`) VALUES ('車');
-- INSERT INTO `unit` (`name`) VALUES ('公斤');
-- INSERT INTO `unit` (`name`) VALUES ('台');

-- ==================================================================================================
-- ==================================================================================================



INSERT INTO `sell_order_item` (`order_id`, `item_id`, `unit_id`, `unit_amount`,`final_per_unit_price`)
    VALUES (1, 1, 1, 10,444);
INSERT INTO `sell_order_item` (`order_id`, `item_id`, `unit_id`, `unit_amount`,`final_per_unit_price`)
    VALUES (1, 2, 2, 5,555);

-- ==================================================================================================
-- ==================================================================================================


INSERT INTO `buy_order_item` (`order_id`, `item_id`, `unit_id`, `unit_amount`,`final_per_unit_price`)
    VALUES (1, 1, 1, 9, 123);
INSERT INTO `buy_order_item` (`order_id`, `item_id`, `unit_id`, `unit_amount`,`final_per_unit_price`)
    VALUES (1, 2, 2, 4, 456);

-- ==================================================================================================
-- ==================================================================================================


-- group 1 pricing
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES (1, 1, 1, 99,100 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price` ,`sell_price`)
    VALUES (1, 1, 2, 199,200 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price` ,`sell_price`)
    VALUES (1, 2, 1, 299,300 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price` ,`sell_price`)
    VALUES (1, 2, 2, 599,600 );

-- group 2 pricing : use group1's pricing * 0.9
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES (2, 1, 1, (100*0.9)-1 , 100*0.9 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES (2, 1, 2, (200*0.9)-1 , 200*0.9 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES (2, 2, 1, (300*0.9)-1 , 300*0.9 );
INSERT INTO `price` (`group_id`, `item_id`, `unit_id`, `buy_price`, `sell_price`)
    VALUES (2, 2, 2, (600*0.9)-1 , 600*0.9 );

-- ==================================================================================================
-- ==================================================================================================