<?php

function getOrderBy($sort) {

  $mode = 'ASC';
  if(starts_with($sort, '+') || starts_with($sort, '-')) {
    $mode = (substr($sort, 0, 1)) == '+' ? 'ASC' : 'DESC';
    $field = substr($sort, 1);
  } else {
    $field = $sort;
  }

  return [$field, $mode];
}

function resourceNotAllowed() {
  return response()->json('Not allowed', 403);
}

function resourceNotFound() {
  return response()->json('Record not found', 404);
}
