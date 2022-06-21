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
