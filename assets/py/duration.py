from mutagen.mp3 import MP3
import sys


def main():
    return to_string(sys.argv[1])


def duration(filename):
    audio = MP3(filename)
    minute=audio.info.length//60
    seconds=audio.info.length-minute*60
    return minute,seconds

def to_string(filename):
    minute, seconds=duration(filename)
    minute=int(minute)
    seconds=int(seconds)
    if seconds<10:
        return "{}:0{}".format(minute, seconds)
    return "{}:{}".format(minute, seconds)


if __name__=="__main__":
    print(main())