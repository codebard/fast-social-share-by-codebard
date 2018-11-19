<?php


$date_selects='<fieldset class="date"> 
  <legend>Start Date </legend> 
  <label>'.$this->lang['label_start_date_month'].'</label> 
  <select id="{start_month_select_id}" 
          name="{start_month_select_name}"> 
    <option value="01">'.$this->lang['month_01'].'</option>         
    <option value="02">'.$this->lang['month_02'].'</option>         
    <option value="03">'.$this->lang['month_03'].'</option>         
    <option value="04">'.$this->lang['month_04'].'</option>         
    <option value="05">'.$this->lang['month_05'].'</option>         
    <option value="06">'.$this->lang['month_06'].'</option>         
    <option value="07">'.$this->lang['month_07'].'</option>         
    <option value="08">'.$this->lang['month_08'].'</option>         
    <option value="09">'.$this->lang['month_09'].'</option>         
    <option value="10">'.$this->lang['month_10'].'</option>         
    <option value="11">'.$this->lang['month_11'].'</option>         
    <option value="12">'.$this->lang['month_12'].'</option>         
  </select> - 
  <label>'.$this->lang['label_start_date_day'].'</label> 
  <select id="{start_day_select_name}" 
          name="{start_day_select_name}"> 
    <option value="01">1</option>       
    <option value="02">2</option>       
    <option value="03">3</option>       
    <option value="04">4</option>       
    <option value="05">5</option>       
    <option value="06">6</option>       
    <option value="07">7</option>       
    <option value="08">8</option>       
    <option value="09">9</option>       
    <option value="10">10</option>       
    <option value="11">11</option>       
    <option value="12">12</option>       
    <option value="13">13</option>       
    <option value="14">14</option>       
    <option value="15">15</option>       
    <option value="16">16</option>       
    <option value="17">17</option>       
    <option value="18">18</option>       
    <option value="19">19</option>       
    <option value="20">20</option>       
    <option value="21">21</option>       
    <option value="22">22</option>       
    <option value="23">23</option>       
    <option value="24">24</option>       
    <option value="25">25</option>       
    <option value="26">26</option>       
    <option value="27">27</option>       
    <option value="28">28</option>       
    <option value="29">29</option>       
    <option value="30">30</option>       
    <option value="31">31</option>       
  </select> - 
  <label>'.$this->lang['label_start_date_year'].'</label> 
  <select id="{start_day_select_year}" 
         name="{start_day_select_year}"> 
    <option>2009</option>       
    <option>2010</option>       
    <option>2011</option>       
    <option>2012</option>       
    <option>2013</option>       
    <option>2014</option>       
    <option>2015</option>       
    <option>2016</option>       
    <option>2017</option>       
    <option>2018</option>       
  </select> 
  <span class="inst">('.$this->lang['month'].'-'.$this->lang['day'].'-'.$this->lang['year'].')</span> 
</fieldset> 

<fieldset class="date"> 
  <legend>'.$this->lang['label_end_date_month'].'</legend> 
  <label>'.$this->lang['label_end_date_month'].'</label> 
  <select id="{start_month_select_id}" 
          name="{start_month_select_name}"> 
    <option value="01">'.$this->lang['month_01'].'</option>         
    <option value="02">'.$this->lang['month_02'].'</option>         
    <option value="03">'.$this->lang['month_03'].'</option>         
    <option value="04">'.$this->lang['month_04'].'</option>         
    <option value="05">'.$this->lang['month_05'].'</option>         
    <option value="06">'.$this->lang['month_06'].'</option>         
    <option value="07">'.$this->lang['month_07'].'</option>         
    <option value="08">'.$this->lang['month_08'].'</option>         
    <option value="09">'.$this->lang['month_09'].'</option>         
    <option value="10">'.$this->lang['month_10'].'</option>         
    <option value="11">'.$this->lang['month_11'].'</option>         
    <option value="12">'.$this->lang['month_12'].'</option>         
  </select> - 
  <label>'.$this->lang['label_start_date_day'].'</label> 
  <select id="{start_month_select_id}" 
		name="{start_month_select_id}" /> 
	<option value="01">1</option>       
	<option value="02">2</option>       
	<option value="03">3</option>       
	<option value="04">4</option>       
	<option value="05">5</option>       
	<option value="06">6</option>       
	<option value="07">7</option>       
	<option value="08">8</option>       
	<option value="09">9</option>       
	<option value="10">10</option>       
	<option value="11">11</option>       
	<option value="12">12</option>       
	<option value="13">13</option>       
	<option value="14">14</option>       
	<option value="15">15</option>       
	<option value="16">16</option>       
	<option value="17">17</option>       
	<option value="18">18</option>       
	<option value="19">19</option>       
	<option value="20">20</option>       
	<option value="21">21</option>       
	<option value="22">22</option>       
	<option value="23">23</option>       
	<option value="24">24</option>       
	<option value="25">25</option>       
	<option value="26">26</option>       
	<option value="27">27</option>       
	<option value="28">28</option>       
	<option value="29">29</option>       
	<option value="30">30</option>       
	<option value="31">31</option>       
	</select> - 
  <label for="year_end">'.$this->lang['year'].'</label> 
  <select id="{end_month_select_id}" 
         name="year_end"> 
    <option>2009</option>       
    <option>2010</option>       
    <option>2011</option>       
    <option>2012</option>       
    <option>2013</option>       
    <option>2014</option>       
    <option>2015</option>       
    <option>2016</option>       
    <option>2017</option>       
    <option>2018</option>       
  </select> 
  <span class="inst">('.$this->lang['month'].'-'.$this->lang['day'].'-'.$this->lang['year'].')</span> 
</fieldset>';