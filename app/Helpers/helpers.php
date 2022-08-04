<?php

if (!function_exists('render_status')) {
  function render_status($status)
  {
    $html = "";
    switch ($status) {
      case QUESTION_STATUS_CREATED:
        $html = '<span class="badge bg-gray">:status</span>';
        break;
      case QUESTION_STATUS_WAITING_REVIEW:
        $html = '<span class="badge bg-primary">:status</span>';
        break;
      case QUESTION_STATUS_REVIEWED:
        $html = '<span class="badge bg-success-light text-success">:status</span>';
        break;
      case QUESTION_STATUS_REJECTED:
        $html = '<span class="badge bg-danger">:status</span>';
        break;
      case QUESTION_STATUS_APPROVED:
        $html = '<span class="badge bg-success">:status</span>';
        break;
      case QUESTION_STATUS_DELETED:
        $html = '<span class="badge bg-danger">:status</span>';
        break;
      default:
        $html = '<span class="badge bg-gray">:status</span>';
        break;
    }
    return str_replace(':status', config('fixeddata.question_status')[$status], $html);
  }
}

if (!function_exists('render_es_status')) {
  function render_es_status($status)
  {
    $html = "";
    switch ($status) {
      case EXAM_SET_STATUS_CREATED:
        $html = '<span class="px-2 py-2 bg-gray ">:status</span>';
        break;
      case EXAM_SET_STATUS_APPROVED:
        $html = '<span class="px-2 py-2 bg-success text-white">:status</span>';
        break;
      case EXAM_SET_STATUS_REJECT:
        $html = '<span class="px-2 py-2 bg-danger text-white">:status</span>';
        break;
      default:
        $html = '<span class="badge bg-gray">:status</span>';
        break;
    }
    return str_replace(':status', config('fixeddata.exam_set_status')[$status], $html);
  }
}