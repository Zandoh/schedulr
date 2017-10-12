# Schedulr
Senior Development Project

## Prerequisites
* Node

## Runbook (So Far)

* Clone the repo ``` git clone ```
* Navigate to the directory of the repo
* ``` npm install ```
* ``` npm install gulp -g ```
* ``` gulp ```

### Adding packages
* ``` npm install package-name --save ```

## SASS Style Guide
[SASS Style Guide](https://css-tricks.com/sass-style-guide/)

## Dev local, connect to remote DB
Windows

- Download cmder, the full version ( [http://cmder.net/](http://cmder.net/))
- Open cmder
- Follow Mac/Unix instructions

Mac/Unix

- If not on campus, VPN in
- SSH into server: ```ssh -L 3306:127.0.0.1:3306 abc1234@team-blue.ist.rit.edu```
- Connect to DB: ```mysql -u root -pundercontrol22 --port 3306 -h 127.0.0.1```
- Edit application/config/database.php
- Comment out the line that requires dbInfo.php
- Edit lines 78-80 to match the following:
  - ```dsn => 'mysql:host=127.0.0.1:3306;dbname=schedulrDB'```
  - ```username => 'root'```
  - ```password => '*****'```
  
## Push To Live Site

* ``` git remote add live ssh://push@129.21.183.53/var/repo ```
* ``` git pull ```
* ``` git add . ``` (Optional)
* ``` git commit -m 'Your message' ``` (Optional)
* ``` git push live master --force ```
