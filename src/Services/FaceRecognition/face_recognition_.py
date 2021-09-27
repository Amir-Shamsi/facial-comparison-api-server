import sys
sys.path.append("/")
from facepplib import FacePP, exceptions
face_detection = ""
face_set_initialize = ""
face_search = ""
face_landmarks = ""
dense_facial_landmarks = ""
face_attributes = ""
beauty_score_and_emotion_recognition = ""
face_comparing_local_photo = ''
face_comparing_website_photo = ''

def face_comparing(app, Image1, Image2):
    cmp_ = app.compare.get(image_url1=Image1, image_url2=Image2)

    print('Photo1', '=', cmp_.image1)
    print('Photo2', '=', cmp_.image2)

    # Comparing Photos
    if cmp_.confidence > 70:
        print(True+'&'+cmp_.confidence)
    else:
        print(False+'&'+cmp_.confidence)

if __name__ == '__main__':

    api_key = 'xQLsTmMyqp1L2MIt7M3l0h-cQiy0Dwhl'
    api_secret = 'TyBSGw8NBEP9Tbhv_JbQM18mIlorY6-D'

    try:
        app_ = FacePP(api_key=api_key, api_secret=api_secret)
        funcs = [
            face_detection,
            face_comparing_local_photo,
            face_comparing_website_photo,
            face_set_initialize,
            face_search,
            face_landmarks,
            dense_facial_landmarks,
            face_attributes,
            beauty_score_and_emotion_recognition
        ]
        image1 = 'https://nitratine.net/posts/python-face-recognition-tutorial/single-person.jpg'
        image2 = 'https://nitratine.net/posts/python-face-recognition-tutorial/single-person.jpg'

        # image1 = input()
        # image2 = input()

        face_comparing(app_, image1, image2)

    except exceptions.BaseFacePPError as e:
        print('Error:', e)
