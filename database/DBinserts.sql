INSERT INTO AVAILABILITY_DATE (availability_day, availability_time_of_day) VALUES ("2017-10-31", "am"), ("2017-10-31", "pm"), ("2017-11-1", "am"), ("2017-11-1", "pm");
INSERT INTO BLACKOUT_DATE (blackout_date_start, blackout_date_end) VALUES ("2017-10-01 12:00:00", "2017-10-08 12:00:00"), ("2017-11-19 12:00:00", "2017-11-26 12:00:00");
INSERT INTO CONGREGATION (congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip) VALUES ("Two Saints", "100 main street", "5855551234", 1, "Rochester", "NY", "14624"), ("DUPC", "450 dang ave", "5852324434", 0, "Rochester", "NY", "14624");
INSERT INTO BUS_SCHEDULE (bus_schedule_name, bus_schedule_start, bus_schedule_end) VALUES ("Schedule 2018 August & September", "2018-08-01", "2018-09-30");
INSERT INTO SCHEDULE_STATE (state_name) VALUES ("In progress"), ("Complete"), ("Draft");
INSERT INTO CONGREGATION_SCHEDULE (congregation_schedule_name, congregation_schedule_start_date, congregation_schedule_end_date) VALUES ("Schedule 2017", "2017-01-01", "2017-12-31");
-- FK constraints apply to these inserts
INSERT INTO USER (password, email, phone_number, first_name, last_name, user_type, congregation_ID) VALUES ("nonhashedpassword", "arl1234@rit.edu", "5555555555", "John", "Smith", "e", 1);
INSERT INTO BUS_DRIVER_AVAILABILITY (user_ID, availability_date_ID) VALUES (1,1);
INSERT INTO CONGREGATION_BLACKOUT_DATE (congregation_ID, blackout_date_ID) VALUES (1,1);
INSERT INTO BUS_SCHEDULE_ASSIGNMENT (user_ID, bus_schedule_ID, scheduled_day, scheduled_time_of_day) VALUES (1,1,"2017-09-26","am");
INSERT INTO BUS_SCHEDULE_HISTORY (bus_schedule_ID, state_ID, work_start_date, work_start_time, work_end_date, work_end_time) VALUES (1,1,"2018-07-20", "12:12:00", "2018-07-20", "13:12:00");
INSERT INTO CONGREGATION_SCHEDULE_HISTORY (congregation_schedule_ID, state_ID, work_start_date, work_start_time, work_end_date, work_end_time) VALUES (1, 1, "2016-07-20", "08:12:00", "2016-012-20", "16:12:00");
INSERT INTO CONGREGATION_SCHEDULE_ASSIGNMENT (congregation_ID, congregation_schedule_ID, scheduled_date_start, scheduled_date_end) VALUES (1, 1, "2017-09-17", "2017-09-24");
