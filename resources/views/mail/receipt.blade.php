<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>[領収書]</title>
	<style type="text/css">
		body {
			padding-top: 0 !important;
			padding-bottom: 0 !important;
			padding-top: 0 !important;
			padding-bottom: 0 !important;
			margin: 0 !important;
			width: 100% !important;
			-webkit-text-size-adjust: 100% !important;
			-ms-text-size-adjust: 100% !important;
			-webkit-font-smoothing: antialiased !important;
			font-family: aozoraminchomedium;
			background-color: #fff
		}

		.tableContent img {
			border: 0 !important;
			display: block !important;
			outline: none !important;
		}

		a {
			color: #382F2E;
		}

		p,
		h1,
		h2,
		ul,
		ol,
		li,
		div {
			margin: 0;
			padding: 0;
		}

		h1,
		h2 {
			font-weight: normal;
			background: transparent !important;
			border: none !important;
		}

		@media only screen and (max-width:480px) {

			table[class="MainContainer"],
			td[class="cell"] {
				width: 100% !important;
				height: auto !important;
			}

			td[class="specbundle"] {
				width: 100% !important;
				float: left !important;
				font-size: 13px !important;
				line-height: 17px !important;
				display: block !important;
				padding-bottom: 15px !important;
			}

			td[class="specbundle2"] {
				width: 80% !important;
				float: left !important;
				font-size: 13px !important;
				line-height: 17px !important;
				display: block !important;
				padding-bottom: 10px !important;
				padding-left: 10% !important;
				padding-right: 10% !important;
			}

			td[class="spechide"] {
				display: none !important;
			}

			img[class="banner"] {
				width: 100% !important;
				height: auto !important;
			}

			td[class="left_pad"] {
				padding-left: 15px !important;
				padding-right: 15px !important;
			}
		}

		@media only screen and (max-width:599px) {

			table[class="MainContainer"],
			td[class="cell"] {
				width: 100% !important;
				height: auto !important;
			}

			td[class="specbundle"] {
				width: 100% !important;
				float: left !important;
				font-size: 13px !important;
				line-height: 17px !important;
				display: block !important;
				padding-bottom: 15px !important;
			}

			td.specbundle.specbundle-plan,
			td.specbundle.specbundle-period,
			td.specbundle.specbundle-price {
				width: 100% !important;
				float: left !important;
				font-size: 13px !important;
				line-height: 17px !important;
				display: block !important;
				box-sizing: border-box;
			}

			td.specbundle.specbundle-plan span,
			td.specbundle.specbundle-period span,
			td.specbundle.specbundle-price span {
				width: calc(100% - 110px) !important;
				display: inline-block;
				vertical-align: middle;
			}

			td.specbundle.specbundle-plan::before,
			td.specbundle.specbundle-period::before,
			td.specbundle.specbundle-price::before {
				text-align: left;
				display: inline-block;
				width: 100px;
				font-weight: 700;
			}

			td.specbundle.specbundle-plan::before {
				content: "ご契約プラン";
			}

			td.specbundle.specbundle-period::before {
				content: "期間";
			}

			td.specbundle.specbundle-price::before {
				content: "価格";
			}

			td[class="specbundle2"] {
				width: 80% !important;
				float: left !important;
				font-size: 13px !important;
				line-height: 17px !important;
				display: block !important;
				padding-bottom: 10px !important;
				padding-left: 10% !important;
				padding-right: 10% !important;
			}

			td[class="spechide"] {
				display: none !important;
			}

			img[class="banner"] {
				width: 100% !important;
				height: auto !important;
			}

			td[class="left_pad"] {
				padding-left: 15px !important;
				padding-right: 15px !important;
			}
		}

		.contentEditable h2.big,
		.contentEditable h1.big {
			font-size: 26px !important;
		}

		.contentEditable h2.bigger,
		.contentEditable h1.bigger {
			font-size: 37px !important;
		}

		.contentEditableAddress,
		.contentEditableDate {
			font-size: 9px;
		}

		.contentEditableCompany {
			font-size: 10px;
			font-weight: 700;
		}

		td,
		table {
			vertical-align: top;
		}

		td.middle {
			vertical-align: middle;
		}

		a.link1 {
			font-size: 13px;
			color: #27A1E5;
			line-height: 24px;
			text-decoration: none;
		}

		a {
			text-decoration: none;
		}

		.link2 {
			color: #ffffff;
			border-top: 10px solid #27A1E5;
			border-bottom: 10px solid #27A1E5;
			border-left: 18px solid #27A1E5;
			border-right: 18px solid #27A1E5;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			background: #27A1E5;
		}

		.link3 {
			color: #555555;
			border: 1px solid #cccccc;
			padding: 10px 18px;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			background: #ffffff;
		}

		.link4 {
			color: #27A1E5;
			line-height: 24px;
		}

		h2,
		h1 {
			line-height: 20px;
		}

		p {
			font-size: 14px;
			line-height: 12px;
		}

		.contentEditable li {}

		.appart p {}

		.bgItem {
			background: #ffffff;
		}

		.bgBody {
			background: #ffffff;
		}

		img {
			outline: none;
			text-decoration: none;
			-ms-interpolation-mode: bicubic;
			width: auto;
			max-width: 100%;
			clear: both;
			display: block;
			float: none;
		}
	</style>

	<script type="colorScheme" class="swatch active">
		{
			"name":"Default",
			"bgBody":"ffffff",
			"link":"27A1E5",
			"color":"AAAAAA",
			"bgItem":"ffffff",
			"title":"444444"
		}
	</script>
</head>

<body paddingwidth="0" paddingheight="0" bgcolor="#d1d3d4"
	style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;"
	offset="0" toppadding="0" leftpadding="0">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td>
					<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff"
						class="MainContainer">
						<!-- =============== START HEADER =============== -->
						<tbody>
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td class="movableContentContainer">
																	<div class="movableContent"
																		style="border: 0px; padding-top: 0px; position: relative;">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td height="15"></td>
																				</tr>
																				<tr>
																					<td>
																						<table width="100%" border="0" cellspacing="0" cellpadding="0">
																							<tbody>
																								<tr>
																									<td valign="middle" style='vertical-align: middle;' class="specbundle">
																										<div class='contentEditableContainer contentTextEditable'>
																											<div class='contentEditable'>
																												<div class="contentEditableAddress">〒{{$company->post_code}}<br/>
																													{{$company->address}}</div>
																												<div class="contentEditableCompany" style="margin-top: 5px;">
																													{{$company->office_name}}<br/>
																													{{$company->account_manager_name}}様
																												</div>
																											</div>
																										</div>
																									</td>
																									<td valign="top" width="90" class="spechide">&nbsp;</td>
																									<td valign="top" width='150' class="specbundle">
																										<table width="100%" border="0" cellspacing="0" cellpadding="0">
																											<tbody>
																												<tr>
																													<td valign="middle" style='vertical-align: middle; padding-top: 5px;'>
																														<img src="{{asset('assets/images/favico.png')}}">
																													</td>
																												</tr>
																												<tr>
																													<td valign="middle" style='vertical-align: middle; padding-top: 5px;'>
																														<div class='contentEditableContainer contentTextEditable'>
																															<div class='contentEditable contentEditableDate'>
																																{{$year}}年{{$month}}月{{$day}}日<br/>
																																No.{{$year}}{{$month}}{{$day}}-R-{{$company->corp_id}}
																															</div>
																														</div>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																	<!-- =============== END HEADER =============== -->
																	<!-- =============== START BODY =============== -->
																	<div class="movableContent"
																		style="border: 0px; padding-top: 0px; position: relative;">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td height='30'></td>
																				</tr>
																				<tr>
																					<td>
																						<table width="100%" border="0" cellspacing="0" cellpadding="0">
																							<tbody>
																								<tr>
																									<td valign="top" width="40">&nbsp;</td>
																									<td>
																										<table width="100%" border="0" cellspacing="0" cellpadding="0"
																											align="center">
																											<tr>
																												<td height='25'></td>
																											</tr>
																											<tr>
																												<td>
																													<div class='contentEditableContainer contentTextEditable'>
																														<div class='contentEditable' style='text-align: center;'>
																															<h2 style="font-size: 18px;"><b>領収書</b></h2>
																														</div>
																													</div>
																												</td>
																											</tr>
																											<tr>
																												<td height='24'></td>
																											</tr>
																										</table>
																									</td>
																									<td valign="top" width="40">&nbsp;</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																	<div class="movableContent"
																		style="border: 0px; padding-top: 0px; position: relative;">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td height="40"></td>
																				</tr>
																				<tr>
																					<td>
																						<table width="100%" border="0" cellspacing="0" cellpadding="0">
																							<tbody>
																								<tr>
																									<td class="specbundle">
																										<div class='contentEditableContainer contentTextEditable'>
																											<div class='contentEditable' style='text-align: left; font-size: 8px;'>
																												<h2 style="font-size: 10px; margin-bottom: 20px;">下記の通り、領収いたしました。</h2>
																												<table width="100%" border="0" cellspacing="0" cellpadding="0"
																													align="center">
																													<tr>
																														<td style="border-top: 1px solid #d7d7d7; width: 50px; padding: 2px 0 2px 10px;">
																															ご契約プラン
																														</td>
																														<td style="border-top: 1px solid #d7d7d7;">：</td>
																														<td style="border-top: 1px solid #d7d7d7; padding: 2px 10px 2px 0;">
																															{{$plan->name}}
																														</td>
																													</tr>
																													<tr>
																														<td style="border-top: 1px solid #d7d7d7; padding: 2px 0 2px 10px;">
																															ご利用期間　
																														</td>
																														<td style="border-top: 1px solid #d7d7d7;">：</td>
																														<td style="border-top: 1px solid #d7d7d7; padding: 2px 10px 2px 0;">
																														{{$contract->contract_year}}年{{\Carbon\Carbon::parse($date_contract)->format('m')}}月{{\Carbon\Carbon::parse($date_contract)->startOfMonth()->format('d')}}日〜{{$contract->contract_year}}年{{\Carbon\Carbon::parse($date_contract)->format('m')}}月{{\Carbon\Carbon::parse($date_contract)->endOfMonth()->format('d')}}日
																														</td>
																													</tr>
																													<tr>
																														<td style="border-top: 1px solid #d7d7d7; padding: 2px 0 2px 10px;">
																															お支払方法　
																														</td>
																														<td style="border-top: 1px solid #d7d7d7;">：</td>
																														<td style="border-top: 1px solid #d7d7d7; padding: 2px 10px 2px 0;">
																															クレジットカード支払
																														</td>
																													</tr>
																													<tr>
																														<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7; padding: 2px 0 2px 10px;">
																															お支払期限　
																														</td>
																														<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7;">：</td>
																														<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7; padding: 2px 10px 2px 0;">
																														{{\Carbon\Carbon::parse($bill_date)->format('Y')}}年{{\Carbon\Carbon::parse($bill_date)->format('m')}}月{{\Carbon\Carbon::parse($bill_date)->endOfMonth()->format('d')}}日
																														</td>
																													</tr>
																												</table>
																											</div>
																										</div>
																									</td>
																									<td valign="top" width="50" class="specbundle">&nbsp;</td>
																									<td class="specbundle">
																										<div class='contentEditableContainer contentTextEditable'>
																											<div class='contentEditable' style='text-align: left;'>
																												<h2 style="font-size: 12px;"><b>株式会社メディカルスタイルパートナーズ</b></h2>
																												<div style="font-size: 10px; margin-top: 5px;">
																													〒133-0057<br/>
																													東京都江戸川区西小岩1-19-36 2F<br/>
																													代表取締役 青木 忠祐
																												</div>
																											</div>
																										</div>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																	<div class="movableContent"
																		style="border: 0px; padding-top: 0px; position: relative;">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td height="40"></td>
																				</tr>
																				<tr>
																					<td>
																						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
																							<tbody>
																								<tr>
																									<td align="center" style="border-top: 1px solid #d7d7d7; padding: 5px; font-weight: 700;" class="spechide">
																										ご契約プラン
																									</td>
																									<td align="center" style="border-top: 1px solid #d7d7d7; padding: 5px; font-weight: 700;" class="spechide">期間</td>
																									<td align="center" style="border-top: 1px solid #d7d7d7; padding: 5px; font-weight: 700;" class="spechide">
																										価格
																									</td>
																								</tr>
																								<tr>
																									<td align="center" style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle specbundle-plan">
																										<span>HOVIT{{$plan->name}}</span>
																									</td>
																									<td align="center" style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle specbundle-period"><span>２０２１年１１月０１日〜２０２１年１１月３０日</td></span>
																									<td align="right" style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle specbundle-price">
																										<span>{{number_format($plan->amount)}}円</span>
																									</td>
																								</tr>
																								<tr>
																									<td style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle">&nbsp;</td>
																									<td style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle">&nbsp;</td>
																									<td style="border-top: 1px solid #d7d7d7; padding: 5px;" class="specbundle">&nbsp;</td>
																								</tr>
																								<tr>
																									<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7; padding: 5px;" class="spechide">&nbsp;</td>
																									<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7; padding: 5px;" class="spechide">&nbsp;</td>
																									<td style="border-top: 1px solid #d7d7d7; border-bottom: 1px solid #d7d7d7; padding: 5px;" class="spechide">&nbsp;</td>
																								</tr>
																							</tbody>
																						</table>
																						<div style="text-align: right; margin-top: 10px; font-size: 18px; font-weight: 700;">
																							<span style="font-size: 11px;">合計金額（税込）</span>：{{number_format($plan->amount)}}円
																						</div>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>

																	<!-- =============== END BODY =============== -->
																	<!-- =============== START FOOTER =============== -->

																	<div class="movableContent"
																		style="border: 0px; padding-top: 0px; position: relative;">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tbody>
																				<tr>
																					<td height="48"></td>
																				</tr>
																				<tr>
																					<td height="48"></td>
																				</tr>
																				<tr>
																					<td height="48"></td>
																				</tr>
																				<tr>
																					<td>
																						<table width="100%" border="0" cellspacing="0" cellpadding="0">
																							<tbody>
																								<tr>
																									<td>
																										<table width="100%" cellpadding="0" cellspacing="0" align="center">
																											<tr>
																												<td>
																													<div class='contentEditableContainer contentTextEditable'>
																														<div class='contentEditable' style="font-size: 10px;">
																															<p style="font-size: 10px;">
																																お支払等に関するお問い合わせについては下記運営事務局まで<br />
																																いただけますようお願いいたします。
																															</p>
																															<div style="font-size: 12px; font-weight: 700; margin: 10px 0 5px;">HOVIT運営事務局</div>
																															<a style='color:#000;'>MAIL：info@med-hovit.com</a>
																														</div>
																													</div>
																												</td>
																											</tr>
																										</table>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="48"></td>
																				</tr>
																				<tr>
																					<td height="48"></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
												<td valign="top" width="70">&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
