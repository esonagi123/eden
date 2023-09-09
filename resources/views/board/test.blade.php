@extends('base')
﻿
@section('content')
<div class="app-card">
  <ul class="app-board-template-list">    
    <li class="app-active">
      <div class="tw-pt-4 tw-pl-4">
        <input type="checkbox" name="cart" value="" id="" class="app-input-checkbox" title="Check This Article" onclick="" checked="" />
      </div>

      <a class="tw-flex-1" class="tw-flex-1 tw-pl-2" href="#">
        <div class="app-thumbnail">
          <img src=""/>
        </div>
    
        <div class="tw-flex-1">
          <div class="app-list-title tw-flex-wrap">
            <span class="tw-text-primary tw-mr-1">분류?</span>

            <span class="tw-mr-1">글 제목?</span>
            
            <span class="tw-text-primary tw-mr-1">스크랩 수?</span>
          </div>
          
          <div class="app-list-meta">
            <span style="">카테고리 타이틀</span>
                <div class="app-list-member" style="">
                  <span class="member app-author">닉네임</span>
                </div>
              </span>
              <span title="">등록일</span>
              <span class="tw-mr-1">조회 : 조회 수</span>
          </div>
        </div>

        <div class="app-list-comment" cond="$document->getCommentCount()">댓글 카운트</div>
      </a>
    </li>
  </ul>
</div>
@endsection