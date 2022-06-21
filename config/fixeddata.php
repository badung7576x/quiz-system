<?php

return [
  'question_type' => [
    QUESTION_MULTI_CHOICE => 'Trắc nghiệm chọn một đáp án',
    // QUESTION_SHORT_ANSWER => 'Trả lời ngắn',
    // QUESTION_MATCHING => 'Nối đáp án',
    // QUESTION_TRUE_FALSE => 'Đúng sai'
  ],
  'question_status' => [
    QUESTION_STATUS_CREATED => 'Tạo mới',
    QUESTION_STATUS_WAITING_REVIEW => 'Chờ đánh giá',
    QUESTION_STATUS_REVIEWED => 'Chờ phê duyệt',
    QUESTION_STATUS_REJECTED => 'Từ chối phê duyệt',
    QUESTION_STATUS_APPROVED => 'Đã được duyệt',
    QUESTION_STATUS_DELETED => 'Xóa'
  ],
  'question_level' => [
    LEVEL_1 => 'Câu hỏi biết',
    LEVEL_2 => 'Câu hỏi hiểu',
    LEVEL_3 => 'Câu hỏi vận dụng',
    LEVEL_4 => 'Câu hỏi phân tích',
    LEVEL_5 => 'Câu hỏi tổng hợp',
    LEVEL_6 => 'Câu hỏi đánh giá'
  ],
  'role' => [
    ROLE_ADMIN => 'Quản trị viên',
    ROLE_PRO_CHIEF => 'Trưởng bộ môn',
    ROLE_SPECIALIST_TEACHER => 'Giáo viên chuyên môn',
    ROLE_SUBJECT_TEACHER => 'Giáo viên bộ môn',
    ROLE_TEACHER => 'Giáo viên'
  ],
  'exam_set_type' => [
    EXAM_SET_TYPE_15P => 'Đề kiểm tra 15 phút',
    EXAM_SET_TYPE_1T => 'Đề kiểm tra 1 tiết',
    EXAM_SET_TYPE_GK => 'Đề kiểm tra giữa kì',
    EXAM_SET_TYPE_CK => 'Đề kiểm cuối kì',
    EXAM_SET_TYPE_TT => 'Đề thi thử',
  ],
  'answer_index' => [
    1 => 'A',
    2 => 'B',
    3 => 'C',
    4 => 'D'
  ]
];