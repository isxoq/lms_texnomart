from random import random
from ffmpeg_streaming import Formats, Bitrate, Representation, Size, FFProbe
import os
import ffmpeg_streaming
import subprocess

import string
import random

dir_path = os.path.dirname(os.path.realpath(__file__))

src = "/home/admin/web/virtualdars.uz/public_html/frontend/web/pythonApp/video/video.mp4"
logo_src = "/home/admin/web/virtualdars.uz/public_html/frontend/web/pythonApp/virtualdars.png"
out = "/home/admin/web/virtualdars.uz/public_html/frontend/web/pythonApp/media/aaa.m3u8"
key = "/home/admin/web/virtualdars.uz/public_html/frontend/web/pythonApp/media/aaa_key.keyinfo"
key_url = "virtualdars.uz"

video_meta = FFProbe(src)

vHeight = int(video_meta.all().get('streams')[0].get('height'))-200
vWidth = int(video_meta.all().get('streams')[0].get('width'))-200


cmd = 'ffmpeg -y -i '+src+' -i '+logo_src + \
    ' -filter_complex overlay='+str(vWidth)+':'+str(vHeight) +\
    ' -b:v 1M -g 60 -hls_time 10  -hls_key_info_file '+key+' -hls_list_size 0 '+out

key_string = ''.join(random.choice(string.ascii_lowercase) for i in range(32))
print(key_string)

keyfile = open('key.key', 'w')
keyinfo = open('key.keyinfo', 'w')

keyfile.writelines(key_string)
keyinfo.writelines([
    'http://virtualdars.uz/pythonApp/media/snfjsdf.key\n',
    '/home/admin/web/virtualdars.uz/public_html/frontend/web/pythonApp/media/snfjsdf.key\n',
    'bac84cf4e954809cd50e2bcd9c70007f\n'
])


# subprocess.Popen(cmd, shell=True)
# subprocess.call(cmd, shell=True)
