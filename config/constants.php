<?php

$gender = [
  '0' => 'Nữ',
  '1' => 'Nam'
];

if (!defined('GENDER')) define('GENDER', $gender);

// Question level
if (!defined('LEVEL_1')) define('LEVEL_1', 1); // Câu hỏi biết
if (!defined('LEVEL_2')) define('LEVEL_2', 2); // Câu hỏi hiểu
if (!defined('LEVEL_3')) define('LEVEL_3', 3); // Câu hỏi vận dụng
if (!defined('LEVEL_4')) define('LEVEL_4', 4); // Câu hỏi phân tích
if (!defined('LEVEL_5')) define('LEVEL_5', 5); // Câu hỏi tổng hợp
if (!defined('LEVEL_6')) define('LEVEL_6', 6); // Câu hỏi đánh giá

// Question type
if (!defined('QUESTION_MULTI_CHOICE')) define('QUESTION_MULTI_CHOICE', 1); // Câu hỏi trắc nghiệm
if (!defined('QUESTION_SHORT_ANSWER')) define('QUESTION_SHORT_ANSWER', 2); // Câu hỏi trả lời ngắn
if (!defined('QUESTION_MATCHING')) define('QUESTION_MATCHING', 3); // Câu hỏi nối đáp án
if (!defined('QUESTION_TRUE_FALSE')) define('QUESTION_TRUE_FALSE', 4); // Câu hỏi đúng sai

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

