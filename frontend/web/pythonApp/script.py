#!/usr/bin/python3

from re import T
import mysql.connector
import time

import os
import random
import string
from secrets import token_bytes, token_hex
import binascii
import sys
import subprocess
import ffmpeg_streaming
from ffmpeg_streaming import Formats, Bitrate, Representation, Size, FFProbe

logo_src = "/var/www/vhosts/texno-mart.uz/corp.texno-mart.uz/frontend/web/pythonApp/texnomart.png"


conn = mysql.connector.connect(
    host="localhost",
    user="admin_corp",
    password="_02Xq9tz",
    database='admin_corp',
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

            # print(per)

            if(conn.is_connected() == False):
                conn = mysql.connector.connect(
                    host="localhost",
                    user="admin_corp",
                    password="_02Xq9tz",
                    database='admin_corp',
                    autocommit=True,
                    charset='utf8'
                )
                mycursor = conn.cursor(buffered=True)

            sql = f"UPDATE `lesson` SET `stream_percentage`= {per}, `stream_status`={stream_status} WHERE `id`={lesson['id']}"
            mycursor.execute(sql)

        if myresult:

            lesson = dict(zip(columns, myresult))
            src_url = '/var/www/vhosts/texno-mart.uz/corp.texno-mart.uz/frontend/web' + \
                lesson['media_org_src']

            video_meta = FFProbe(src_url)
            video_src = ffmpeg_streaming.input(src_url)
            tid = 0
            if video_meta.all().get('streams')[0].get('height') is None:
                tid = 1
            vHeight = int(video_meta.all().get('streams')[tid].get('height'))-59
            vWidth = int(video_meta.all().get('streams')[tid].get('width'))-225

            duration = int(float(video_meta.format().get('duration')))

            base_url = '/var/www/vhosts/texno-mart.uz/corp.texno-mart.uz/frontend/web'

            letters = string.ascii_lowercase

            for_db_url = '/media/stream/'+str(lesson['course_id'])+'/'+str(lesson['id'])+"/"+''.join(random.choice(letters) for i in range(
                15))+'/'+''.join(random.choice(letters) for i in range(15))

            key_url_folder = for_db_url + '/' + \
                ''.join(random.choice(letters) for i in range(15))

            key_path_folder = base_url + key_url_folder

            # Klyuch yaratish
            key_string = ''.join(random.choice(
                string.ascii_lowercase) for i in range(32))

            os.makedirs(key_path_folder)
            # os.makedirs(base_url+'/media/tmp/'+key_string)
            # os.makedirs(base_url + for_db_url)
            # Key faylni yaratish
            keyfile = open(key_path_folder+'/key.key', 'wb')

            # keyfile = open('/var/www/vhosts/texno-mart.uz/corp.texno-mart.uz/frontend/web/media/stream/7/1090/key.key', 'w')
            # print(keyfile)
            keyfile.write(os.urandom(16))

            # Temp KeyInfo fayl yaratish
            keyinfo = open(base_url+'/enc.keyinfo', 'w')

            keyinfo.write("\n".join(
                [key_url_folder+'/key.key', key_path_folder+'/key.key']))

            sql = f"UPDATE `lesson` SET `media_stream_src`='{for_db_url}', `media_duration`={duration} WHERE `id`={lesson['id']}"
            mycursor.execute(sql)

            for_db_url += "/stream.m3u8"
            # print(for_db_url)

            if(conn.is_connected() == False):
                conn = mysql.connector.connect(
                    host="localhost",
                    user="admin_corp",
                    password="_02Xq9tz",
                    database='admin_corp',
                    autocommit=True,
                    charset='utf8'
                )
            mycursor = conn.cursor(buffered=True)

            sql = f"UPDATE `lesson` SET `media_stream_src`='{for_db_url}', `media_duration`={duration} WHERE `id`={lesson['id']}"
            mycursor.execute(sql)

            # cmd = 'ffmpeg -y -i '+src_url+' -i '+logo_src + \
            #     ' -filter_complex overlay='+str(vWidth)+':'+str(vHeight) +\
            #     ' -b:v 1M -g 30 -c:v h264 -hls_time 10' + \
            #     ' -hls_list_size 0 ' + base_url + for_db_url

            cmd = 'ffmpeg -i \''+src_url+'\' -i '+logo_src + \
                ' -filter_complex overlay='+str(vWidth)+':'+str(vHeight) +\
                ' -b:v 1M -g 30 -c:v h264 -hls_time 10  -hls_key_info_file ' +\
                base_url+'/enc.keyinfo' + \
                ' -hls_list_size 0 ' + base_url + for_db_url
            # print(cmd)
            subprocess.call(cmd, shell=True)

            if(conn.is_connected() == False):
                conn = mysql.connector.connect(
                    host="localhost",
                    user="admin_corp",
                    password="_02Xq9tz",
                    database='admin_corp',
                    autocommit=True,
                    charset='utf8'
                )
            mycursor = conn.cursor(buffered=True)

            sql = f"UPDATE `lesson` SET `stream_status`= 6 WHERE `id`={lesson['id']}"
            mycursor.execute(sql)
            os.remove(src_url)

    except Exception as e:  # Catch exception which will be raise in connection loss

        print(e)
        conn = mysql.connector.connect(
            host="localhost",
            user="admin_corp",
            password="_02Xq9tz",
            database='admin_corp',
            autocommit=True,
            charset='utf8'
        )

        mycursor = conn.cursor(buffered=True)

    finally:
        mycursor.close()

    time.sleep(2)

conn.close()
