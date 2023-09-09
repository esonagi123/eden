@extends('base')
﻿
@section('content')
<div class="container">
	<div class="row">
		<div class="col-7">
			<p><span style="color:#ed675c;"><strong><span style="font-size:14px;">백석대 최고 가성비 원룸</span></strong></span></p>

			<p><span style="font-size: 28px;"><b>안 녕 하 세 요!</b></span></p>

			<p><span style="font-size: 28px;"><b>이 든 하 우 스&nbsp; 입 니 다.</b></span></p>

			<p>&nbsp;</p>

			<p><span style="color:#666666;"><span style="font-size:14px;">이든하우스는&nbsp;백석대 도보 3분거리에 위치하고 있는 대학생 전용 원룸입니다.</span></span></p>

			<p><span style="color:#666666;"><span style="font-size:14px;">합리적인 가격과 높은 만족도를 보장 드리겠습니다.</span></span></p>
		</div>
		<div class="col-lg-5">
		<img src="{{ asset('img/건물정면.jpg') }}">
		</div>
	</div>
</div>

  <div class="fun-facts">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="wrapper">
            <div class="row">
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="48" data-speed="1000"></h2>
                   <p class="count-text ">개의 방</p>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="3" data-speed="1000"></h2>
                  <p class="count-text ">분 거리<br>(학교 정문까지)</p>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="counter">
                  <h2 class="timer count-title count-number" data-to="16" data-speed="1000"></h2>
                  <p class="count-text ">대의 세탁시설<br>(세탁기+건조기)</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="container px-4 py-5" id="icon-grid">
    <h2 class="pb-2 border-bottom">주요 특징</h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 py-5">
      <div class="col-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#bootstrap"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">5층 규모의 원룸</h3>
          <p>주거 시설은 2~5층이며 총 48개의 방으로 구성되어 있습니다.</p>
        </div>
      </div>
      <div class="col-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#cpu-fill"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">안전한 전용 소방설비</h3>
          <p>방과 건물 내부에 스프링클러, 경종 등 전용 소방설비가 갖추어져 있습니다.</p>
        </div>
      </div>
      <div class="col-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#calendar3"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">CCTV 13대 가동 중</h3>
          <p>선명한 CCTV 13대가 건물 내외부를 24시간 녹화 중입니다.</p>
        </div>
      </div>
      <div class="ccol-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#home"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">남녀 층 분리 운영</h3>
          <p>4층과 5층은 여학생 전용 층, 2층은 남학생 전용 층 입니다.</p>
        </div>
      </div>
      <div class="col-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#speedometer2"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">넓은 공용 공간</h3>
          <p>각 16평, 13평 규모의 넓은 공용 공간과 시설이 갖추어져 있습니다</p>
        </div>
      </div>
      <div class="col-md-4">
        <svg class="bi text-body-secondary flex-shrink-0 me-3" width="1.75em" height="1.75em"><use xlink:href="#toggles2"></use></svg>
        <div>
          <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">무료 세탁시설 운영</h3>
          <p>최신 드럼 세탁기 및 건조기를 언제든 무료로 사용하실 수 있습니다.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="section best-deal">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="section-heading">
            <h6>| 둘러보기</h6>
            <h2>방과 건물 내부를<br>볼 수 있어요</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="tabs-content">
            <div class="row">
              <div class="nav-wrapper ">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="appartment-tab" data-bs-toggle="tab" data-bs-target="#appartment" type="button" role="tab" aria-controls="appartment" aria-selected="true">원룸</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="villa-tab" data-bs-toggle="tab" data-bs-target="#villa" type="button" role="tab" aria-controls="villa" aria-selected="false">투룸</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="penthouse-tab" data-bs-toggle="tab" data-bs-target="#penthouse" type="button" role="tab" aria-controls="penthouse" aria-selected="false">공용시설</button>
                  </li>
                </ul>
              </div>              
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="appartment" role="tabpanel" aria-labelledby="appartment-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>면적(평 수)<span>9 m2</span></li>
                          <li>층<span>2~5층</span></li>
                          <li>방 개수<span>40</span></li>
                          <li>공과금/관리비<span>포함</span></li>
                          <li>계약 단위<span>년세/반년세</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="assets/images/deal-01.jpg" alt="">
                    </div>
                    <div class="col-lg-3">
                      <h4>합리적인 가격으로<br>자취 생활을 시작해보세요.</h4>
                      <p>2층 : 남학생 전용</p>
					  <p>3층 : 혼용</p>
					  <p>4층 : 여학생 전용</p>
					  <p>5층 : 여학생 전용</p>
					  <p>엘리베이터 완비</p>
                      <div class="icon-button">
                        <a href="property-details.html"><i class="fa fa-calendar"></i> 원룸 자세히 보기</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="villa" role="tabpanel" aria-labelledby="villa-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>면적(평 수)<span>? m2</span></li>
                          <li>층<span>2~5층</span></li>
                          <li>방 개수<span>8</span></li>
                          <li>공과금/관리비<span>포함</span></li>
                          <li>계약 단위<span>년세/반년세</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="assets/images/deal-02.jpg" alt="">
                    </div>
                    <div class="col-lg-3">
                      <h4>넓고 쾌적한 공간을 원하시나요?</h4>
                      <p>2층 : 남학생 전용</p>
					  <p>3층 : 혼용</p>
					  <p>4층 : 여학생 전용</p>
					  <p>5층 : 여학생 전용</p>
					  <p>엘리베이터 완비</p>					  
                      <div class="icon-button">
                        <a href="property-details.html"><i class="fa fa-calendar"></i>투룸 자세히 보기</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="penthouse" role="tabpanel" aria-labelledby="penthouse-tab">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="info-table">
                        <ul>
                          <li>면적<span>16 + 13 m2</span></li>
                          <li>층<span>1층</span></li>
                          <li>구분<span>여학생 전용/공용</span></li>
                          <li>이용 시간<span>24시간 자유 이용</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <img src="assets/images/deal-03.jpg" alt="">
                    </div>
                    <div class="col-lg-3">
                      <h4>Extra Info About Penthouse</h4>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempor pack incididunt ut labore et dolore magna aliqua quised ipsum suspendisse. <br><br>Swag fanny pack lyft blog twee. JOMO ethical copper mug, succulents typewriter shaman DIY kitsch twee taiyaki fixie hella venmo after messenger poutine next level humblebrag swag franzen.</p>
                      <div class="icon-button">
                        <a href="property-details.html"><i class="fa fa-calendar"></i> Schedule a visit</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="contact section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <div class="section-heading text-center">
            <h6>| Contact Us</h6>
            <h2>더 궁금하신 점이<br>있으신가요?</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div id="map">
            <div style="font:normal normal 400 12px/normal dotum, sans-serif; width:640px; height:392px; color:#333; position:relative"><div style="height: 360px;"><a href="https://map.kakao.com/?urlX=540415.0&amp;urlY=928857.0&amp;name=%EC%B6%A9%EB%82%A8%20%EC%B2%9C%EC%95%88%EC%8B%9C%20%EB%8F%99%EB%82%A8%EA%B5%AC%20%EC%95%88%EC%84%9C%EB%8F%99%20379-44&amp;map_type=TYPE_MAP&amp;from=roughmap" target="_blank"><img class="map" src="http://t1.daumcdn.net/roughmap/imgmap/c5b7715864ce777eda5c45a1a4895cac89df104bd072d8d7a0911e89aea06395" width="638px" height="358px" style="border:1px solid #ccc;"></a></div><div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);"><a href="https://map.kakao.com" target="_blank" style="float: left;"><img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px"></a><div style="float: right; position: relative; top: 1px; font-size: 11px;"><a target="_blank" href="https://map.kakao.com/?from=roughmap&amp;eName=%EC%B6%A9%EB%82%A8%20%EC%B2%9C%EC%95%88%EC%8B%9C%20%EB%8F%99%EB%82%A8%EA%B5%AC%20%EC%95%88%EC%84%9C%EB%8F%99%20379-44&amp;eX=540415.0&amp;eY=928857.0" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a></div></div></div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="item phone">
                <img src="assets/images/phone-icon.png" alt="" style="max-width: 52px;">
                <h6>010-020-0340<br><span>Phone Number</span></h6>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="item email">
                <img src="assets/images/email-icon.png" alt="" style="max-width: 52px;">
                <h6>info@villa.co<br><span>Business Email</span></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <form id="contact-form" action="" method="post">
            <div class="row">
              <div class="col-lg-12">
                <fieldset>
                  <label for="name">Full Name</label>
                  <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="email">Email Address</label>
                  <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="subject">Subject</label>
                  <input type="subject" name="subject" id="subject" placeholder="Subject..." autocomplete="on" >
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="message">Message</label>
                  <textarea name="message" id="message" placeholder="Your Message"></textarea>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <button type="submit" id="form-submit" class="orange-button">Send Message</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection