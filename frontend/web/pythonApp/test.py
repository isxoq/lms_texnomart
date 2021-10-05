import os
import datetime
import sys
import ffmpeg_streaming
from ffmpeg_streaming import Formats, Bitrate, Representation, Size

currentPath = os.path.dirname(os.path.realpath(__file__))
video = ffmpeg_streaming.input(
    '/home/admin/web/onlayndars.uz/virtualdars/frontend/web/ninja/video.mp4')


def monitor(ffmpeg, duration, time_):
    # print(duration)
    # return 1
    """
    Handling proccess.

    Examples:
    1. Logging or printing ffmpeg command
    logging.info(ffmpeg) or print(ffmpeg)

    2. Handling Process object
    if "something happened":
        process.terminate()

    3. Email someone to inform about the time of finishing process
    if time_left > 3600 and not already_send:  # if it takes more than one hour and you have not emailed them already
        ready_time = time_left + time.time()
        Email.send(
            email='someone@somedomain.com',
            subject='Your video will be ready by %s' % datetime.timedelta(seconds=ready_time),
            message='Your video takes more than %s hour(s) ...' % round(time_left / 3600)
        )
       already_send = True

    4. Create a socket connection and show a progress bar(or other parameters) to your users
    Socket.broadcast(
        address=127.0.0.1
        port=5050
        data={
            percentage = per,
            time_left = datetime.timedelta(seconds=int(time_left))
        }
    )

    :param ffmpeg: ffmpeg command line
    :param duration: duration of the video
    :param time_: current time of transcoded video
    :param time_left: seconds left to finish the video process
    :param process: subprocess object
    :return: None
    """
    per = round(time_ / duration * 100)
    sys.stdout.write(
        "\rTranscoding...(%s%%) [%s%s]" %
        (per,  '#' * per, '-' * (100 - per))
    )
    sys.stdout.flush()


_360p = Representation(Size(640, 360), Bitrate(276 * 1024, 128 * 1024))
_480p = Representation(Size(854, 480), Bitrate(750 * 1024, 192 * 1024))
_720p = Representation(Size(1280, 720), Bitrate(2048 * 1024, 320 * 1024))


hls = video.hls(Formats.h264(), hls_time=4)
hls.representations(_720p)

hls.output(
    '/home/admin/web/onlayndars.uz/virtualdars/frontend/web/ninja/media/hls.m3u8', monitor=monitor)
