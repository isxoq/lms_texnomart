#!/usr/bin/python3

import mysql.connector
import time

import os
import random
import string
import sys
import ffmpeg_streaming
from ffmpeg_streaming import Formats, Bitrate, Representation, Size, FFProbe

conn = mysql.connector.connect(
    host="localhost",
    user="admin_virtual",
    password="7riX3vXt4o",
    database='admin_virtual',
    autocommit=True,
    charset='utf8'
)

while True:

    try:
        mycursor = conn.cursor(buffered=True)
        mycursor.execute("""
            SELECT lesson.*,section.kurs_id as course_id FROM lesson
            LEFT JOIN section ON section.id = lesson.section_id
            WHERE lesson.stream_status = 4
            ORDER BY updated_at ASC
            """)
        columns = mycursor.column_names
        myresult = mycursor.fetchone()

        def monitor(line, duration, time_):
            global conn, mycursor
            per = round(time_ / duration * 100)

            if(per != 100):
                stream_status = 5
            else:
                stream_status = 6

            print(per)

            if(conn.is_connected() == False):
                conn = mysql.connector.connect(
                    host="localhost",
                    user="admin_virtual",
                    password="7riX3vXt4o",
                    database='admin_virtual',
                    autocommit=True,
                    charset='utf8'
                )
                mycursor = conn.cursor(buffered=True)

            sql = f"UPDATE `lesson` SET `stream_percentage`= {per}, `stream_status`={stream_status} WHERE `id`={lesson['id']}"
            mycursor.execute(sql)

        if myresult:

            lesson = dict(zip(columns, myresult))
            src_url = '/home/admin/web/virtualdars.uz/public_html/frontend/web' + \
                lesson['media_org_src']

            video_meta = FFProbe(src_url)
            video_src = ffmpeg_streaming.input(src_url)

            _720p = Representation(
                Size(1280, 720), Bitrate(2048 * 1024, 320 * 1024))
            proc_hls = video_src.hls(Formats.h264(), hls_time=10)
            proc_hls.representations(_720p)

            duration = int(float(video_meta.format().get('duration')))

            base_url = '/home/admin/web/virtualdars.uz/public_html/frontend/web'

            letters = string.ascii_lowercase

            for_db_url = '/media/stream/'+str(lesson['course_id'])+'/'+str(lesson['id'])+"/"+''.join(random.choice(letters) for i in range(
                15))+'/'+''.join(random.choice(letters) for i in range(15))

            key_url = for_db_url + '/' + \
                ''.join(random.choice(letters) for i in range(15))+'/key.key'

            key_path = base_url + key_url

            for_db_url += "/stream.m3u8"

            if(conn.is_connected() == False):
                conn = mysql.connector.connect(
                    host="localhost",
                    user="admin_virtual",
                    password="7riX3vXt4o",
                    database='admin_virtual',
                    autocommit=True,
                    charset='utf8'
                )
                mycursor = conn.cursor(buffered=True)

            sql = f"UPDATE `lesson` SET `media_stream_src`='{for_db_url}', `media_duration`={duration},`stream_status`= 5 WHERE `id`={lesson['id']}"
            mycursor.execute(sql)

            proc_hls.encryption(key_path, key_url)
            proc_hls.output(base_url + for_db_url, monitor=monitor)

            os.remove(src_url)

    except Exception as e:  # Catch exception which will be raise in connection loss

        print(e)
        conn = mysql.connector.connect(
            host="localhost",
            user="admin_virtual",
            password="7riX3vXt4o",
            database='admin_virtual',
            autocommit=True,
            charset='utf8'
        )

        mycursor = conn.cursor(buffered=True)

    finally:
        mycursor.close()

    time.sleep(2)

conn.close()
