<?php

$gender = [
  '0' => 'Nữ',
  '1' => 'Nam'
];

if (!defined('GENDER')) define('GENDER', $gender);

// Question level
if (!defined('LEVEL_1')) define('LEVEL_1', 1); // Dễ
if (!defined('LEVEL_2')) define('LEVEL_2', 2); // Trung bình
if (!defined('LEVEL_3')) define('LEVEL_3', 3); // Khó

// Question type
if (!defined('QUESTION_MULTI_CHOICE')) define('QUESTION_MULTI_CHOICE', 1); // Câu hỏi trắc nghiệm
if (!defined('QUESTION_SHORT_ANSWER')) define('QUESTION_SHORT_ANSWER', 2); // Câu hỏi trả lời ngắn
if (!defined('QUESTION_MATCHING')) define('QUESTION_MATCHING', 3); // Câu hỏi nối đáp án
if (!defined('QUESTION_TRUE_FALSE')) define('QUESTION_TRUE_FALSE', 4); // Câu hỏi đúng sai
if (!defined('QUESTION_MULTI_ANSWER')) define('QUESTION_MULTI_ANSWER', 5); // Câu hỏi trắc nghiệm

// Question status
if (!defined('QUESTION_STATUS_CREATED')) define('QUESTION_STATUS_CREATED', 1); // Câu hỏi vừa được tạo
if (!defined('QUESTION_STATUS_WAITING_REVIEW')) define('QUESTION_STATUS_WAITING_REVIEW', 2); // Câu hỏi vừa được tạo
if (!defined('QUESTION_STATUS_REVIEWED')) define('QUESTION_STATUS_REVIEWED', 3); // Câu hỏi đã được duyệt
if (!defined('QUESTION_STATUS_REJECTED')) define('QUESTION_STATUS_REJECTED', 4); // Câu hỏi đã được duyệt
if (!defined('QUESTION_STATUS_APPROVED')) define('QUESTION_STATUS_APPROVED', 5); // Câu hỏi đã được duyệt
if (!defined('QUESTION_STATUS_DELETED')) define('QUESTION_STATUS_DELETED', 6); // Câu hỏi đã được xóa

if (!defined('ROLE_ADMIN')) define('ROLE_ADMIN', 0);
if (!defined('ROLE_PRO_CHIEF')) define('ROLE_PRO_CHIEF', 1);  // Trưởng bộ môn
if (!defined('ROLE_SPECIALIST_TEACHER')) define('ROLE_SPECIALIST_TEACHER', 2);  // Giáo viên chuyên môn
if (!defined('ROLE_SUBJECT_TEACHER')) define('ROLE_SUBJECT_TEACHER', 3);  // Giáo viên bộ môn
if (!defined('ROLE_TEACHER')) define('ROLE_TEACHER', 4);  // Giáo viên cơ bản

if (!defined('EXAM_SET_TYPE_15P')) define('EXAM_SET_TYPE_15P', 1);
if (!defined('EXAM_SET_TYPE_1T')) define('EXAM_SET_TYPE_1T', 2);
if (!defined('EXAM_SET_TYPE_GK')) define('EXAM_SET_TYPE_GK', 3);
if (!defined('EXAM_SET_TYPE_CK')) define('EXAM_SET_TYPE_CK', 4);
if (!defined('EXAM_SET_TYPE_TT')) define('EXAM_SET_TYPE_TT', 5);

if (!defined('EXAM_SET_STATUS_CREATED')) define('EXAM_SET_STATUS_CREATED', 1);
if (!defined('EXAM_SET_STATUS_APPROVED')) define('EXAM_SET_STATUS_APPROVED', 2);
if (!defined('EXAM_SET_STATUS_REJECT')) define('EXAM_SET_STATUS_REJECT', 3);

// num of questions need to create exam set
if (!defined('GENERATE_RATIO')) define('GENERATE_RATIO', 3); 


