import mysql.connector
from random import choice,randint
from datetime import datetime,timedelta

myDB = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="chilawsabha"
)

myCursor = myDB.cursor()

myCursor.execute("SELECT post_id,posted_time,views FROM post")

posts = myCursor.fetchall()


myCursor.execute("DELETE FROM post_views WHERE 1")

for post in posts:
    print(post)
    post_id = post[0]
    posted_time = post[1]
    start = posted_time
    total_views = 0
    while(start <= datetime.now()):
        if(randint(1,2)==1):
            try:
                views = randint(1,20)
                myCursor.execute("INSERT INTO post_views(post_id,date,views) VALUES(%s,%s,%s)",(post_id,start,views))
                total_views += views
            except:
                pass
        start = start + timedelta(days=1)
    myCursor.execute("UPDATE post SET views=%s WHERE post_id=%s",(total_views,post_id))
    myDB.commit()

