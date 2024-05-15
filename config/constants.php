<?php

return [

    'ACTIVATION_LINK_PATH' => env('ACTIVATION_LINK_PATH'),
    'PROJECT_NAME' => 'ob_testimonial',

    'QR_API_PATH' => env('QR_API_PATH'),

    'APP_NAME' => env('APP_NAME'),
    'AWS_BUCKET' => env('AWS_BUCKET'),
    'AWS_BUCKET_ROOT_DIR' => env('AWS_BUCKET_ROOT_DIR'),

    'EXCEPTION_ERROR' => 'OB Testimonial is unable to ',
    'EXCEPTION_ACTION_ERROR' => ' please contact at info@optimumbrew.com',
    'DATE_FORMAT' => 'Y-m-d H:i:s',

    'ROLE_FOR_ADMIN' => 'admin',
    'ROLE_FOR_USER' => 'user',

    'ROLE_ID_FOR_ADMIN' => 1,
    'ROLE_ID_FOR_USER' => 2,

    'ADMIN_ID' => env('ADMIN_ID'),
    'SUB_ADMIN_ID' => env('SUB_ADMIN_ID'),
    'GUEST_ID' => env('GUEST_ID'),

    'ADMIN_EMAIL_ID' => env('ADMIN_EMAIL_ID'),
    'SUB_ADMIN_EMAIL_ID' => env('SUB_ADMIN_EMAIL_ID'),
    'PROJECT_MANAGER_EMAIL_ID' => env('PROJECT_MANAGER_EMAIL_ID'),

    'RESPONSE_HEADER_CACHE' => 'max-age=2592000',    // 30 days caching response data

    //redis key parameter
    'REDIS_KEY' => env('REDIS_KEY'),

    'GUEST_USER_UD' => 'guest@gmail.com',
    'GUEST_PASSWORD' => 'demo@123',

    'APP_ENV' => env('APP_ENV'),
    'STORAGE' => env('STORAGE'),

    'PATH_OF_CWEBP' => env('PATH_OF_CWEBP'),
    'FFMPEG_PATH' => env('FFMPEG_PATH'),
    'FFPROBE_PATH' => env('FFPROBE_PATH'),

    'ORIGINAL_IMAGES_DIRECTORY' => 'image_bucket/original/',
    'COMPRESSED_IMAGES_DIRECTORY' => 'image_bucket/compressed/',
    'VIDEO_DIRECTORY' => 'image_bucket/video/',
    'TEMP_IMAGES_DIRECTORY' => 'image_bucket/temp/',
    'WEBP_THUMBNAIL_IMAGES_DIRECTORY' => 'image_bucket/webp_thumbnail/',
    'JSON_FILE_DIRECTORY' => 'image_bucket/json/',

    'IMAGE_BUCKET_ORIGINAL_IMG_PATH' => env('IMAGE_BUCKET_ORIGINAL_IMG_PATH'),
    'IMAGE_BUCKET_ORIGINAL_VIDEO_PATH' => env('IMAGE_BUCKET_ORIGINAL_VIDEO_PATH'),
    'IMAGE_BUCKET_WEBP_THUMBNAIL_IMG_PATH' => env('IMAGE_BUCKET_WEBP_THUMBNAIL_IMG_PATH'),

    'ORIGINAL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN' => env('ORIGINAL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN'),
    'COMPRESSED_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN' => env('COMPRESSED_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN'),
    'VIDEO_DIRECTORY_OF_DIGITAL_OCEAN' => env('VIDEO_DIRECTORY_OF_DIGITAL_OCEAN'),
    'WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN' => env('WEBP_THUMBNAIL_IMAGES_DIRECTORY_OF_DIGITAL_OCEAN'),

    /* BackEnd Logs credential */
    'LOG_USERNAME' => env('LOG_USERNAME'),
    'LOG_PASSWORD' => env('LOG_PASSWORD'),

    /* quality of image compression */
    'QUALITY' => '75',

    'THUMBNAIL_HEIGHT' => 240,
    'THUMBNAIL_WIDTH' => 320,

    'MAX_LENGTH_FOR_URL' => 400,

    /* For API Caching in Seconds*/
    'CACHE_TIME_6_HOUR_IN_SEC' => '21600',
    'CACHE_TIME_24_HOUR_IN_SEC' => '86400',
    'CACHE_TIME_48_HOUR_IN_SEC' => '172800',
    'CACHE_TIME_7_DAYS_IN_SEC' => '604800',

    /* File size and duration validation */
    'MINIMUM_FILE_DURATION' => env('MINIMUM_FILE_DURATION'),
    'MAXIMUM_FILE_DURATION' => env('MAXIMUM_FILE_DURATION'),
    'MAXIMUM_FILESIZE' => env('MAXIMUM_FILESIZE'),

    'CONTENT_TYPE_OF_FREE_MAIL' => 1,
    'CONTENT_TYPE_OF_BEFORE_PAID_MAIL' => 2,
    'CONTENT_TYPE_OF_AFTER_PAID_MAIL' => 3,

    'FEEDBACK_TYPE_OF_PENDING' => 1,
    'FEEDBACK_TYPE_OF_DONE' => 2,
    'FEEDBACK_TYPE_OF_REJECT' => 3,
    'FEEDBACK_TYPE_OF_ALREADY_GIVEN' => 4,

    'REWARD_TYPE_OF_AMAZON' => 1,
    'REWARD_TYPE_OF_CUSTOM' => 2,
    'CDN_PATH_FOR_BLADE_FILE' => 'https://d29sxmrfclv7li.cloudfront.net/testimonial/'
];
