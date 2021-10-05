import os
import random
import string
import sys
import mysql.connector
import ffmpeg_streaming
from ffmpeg_streaming import Formats, Bitrate, Representation, Size, FFProbe


class HLS:

    db = mysql.connector.connect(
        host="localhost",
        user="admin_virtual",
        password="7riX3vXt4o",
        database='admin_virtual'
    )
    
    # def getMustBeStreamedLessons(self):
    #     self.db.connect()
    #     mycursor = self.db.cursor()
    #     mycursor.execute("SELECT * FROM lesson WHERE `stream_status`=5")

    #     columns = mycursor.column_names
    #     myresult = mycursor.fetchall()
    #     array1 = []
    #     for lesson in myresult:
    #         # array1.append(dict(zip(columns, lesson)))
    #         array1.append(lesson)
    #     # if myresult:
    #     #     dict1 =
    #     # else:
    #     #     dict1 = False

    #     return array1

    def getLessonData(self):
        self.db.connect()
        mycursor = self.db.cursor()
        mycursor.execute("SELECT * FROM lesson WHERE id="+str(self.lesson_id))

        columns = mycursor.column_names
        myresult = mycursor.fetchone()
        if myresult:
            dict1 = dict(zip(columns, myresult))
        else:
            dict1 = False

        return dict1

    def runProcess(self):

        lesson_data = self.getLessonData()

        if lesson_data:
            src_url = '/home/admin/web/onlayndars.uz/virtualdars/frontend/web' + \
                lesson_data['media_org_src']

            video_meta = FFProbe(src_url)
            video_src = ffmpeg_streaming.input(src_url)

            _720p = Representation(
                Size(1280, 720), Bitrate(2048 * 1024, 320 * 1024))
            proc_hls = video_src.hls(Formats.h264(), hls_time=10)
            proc_hls.representations(_720p)

            duration = int(float(video_meta.format().get('duration')))

            base_url = '/home/admin/web/onlayndars.uz/virtualdars/frontend/web'

            letters = string.ascii_lowercase

            for_db_url = '/media/stream/'+str(self.kurs_id)+'/'+''.join(random.choice(letters) for i in range(
                15))+'/'+''.join(random.choice(letters) for i in range(15))
            # print(base_url + for_db_url)

            key_url = for_db_url + '/' + \
                ''.join(random.choice(letters) for i in range(15))+'/key.key'

            key_path = base_url + key_url

            for_db_url += "/stream.m3u8"

            self.setLessonStatus({
                'stream_status': 5
            })

            proc_hls.encryption(key_path, key_url)
            proc_hls.output(base_url + for_db_url)

            self.setLessonData({
                'stream_src': for_db_url,
                'media_duration': duration,
                'stream_status': 6
            })
            os.remove(src_url)

        return

    def setLessonData(self, data):
        self.db.connect()
        mycursor = self.db.cursor()
        sql = f"UPDATE `lesson` SET `media_stream_src`='{data['stream_src']}', `media_duration`={data['media_duration']},`stream_status`= 6 WHERE `id`={self.lesson_id}"
        # print(sql)
        mycursor.execute(sql)
        self.db.commit()
        return

    def setLessonStatus(self, data):
        self.db.connect()
        mycursor = self.db.cursor()
        sql = f"UPDATE `lesson` SET `stream_status`='{data['stream_status']}' WHERE `id`={self.lesson_id}"
        # print(sql)
        mycursor.execute(sql)
        self.db.commit()
        return

    def closeMysql(self):
        self.db.close()
