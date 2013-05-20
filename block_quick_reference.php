<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing HTML block instances.
 *
 * @package   block_quick_reference
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_quick_reference extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_quick_reference');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('quickreference', 'block_quick_reference'));
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {

		global $CFG, $USER;
    
		if ($this->content !== null) {
		  return $this->content;
		}
 
		$this->content         =  new stdClass;
			$this->content->text   =  <<<EOF
<div id="quick_ref_block">
	<form method="get" action="{$CFG->wwwroot}/course/search.php">
		<fieldset class="coursesearchbox invisiblefieldset">
			<b>Course search:</b>
			<input style="width: 160px;" id="coursesearchbox" name="search" />
			<input type="submit" value="Go" />
		</fieldset>
	</form>
	
	<br />
	
	<!--form method="get" action="https://vle.conel.ac.uk/admin/user.php" style="margin-top: 5px;">
		<fieldset class="coursesearchbox invisiblefieldset">
			<b>User search:</b> ID Number: <input size="30" style="width: 185px;" name="idnumber" /><br />
			Firstname: <input size="30" style="width: 185px;" name="firstname" /><br />
			Lastname: <input size="30" style="width: 185px;" name="lastname" /> 
			<input type="submit" value="Go" />
		</fieldset>
	</form-->

	<form class="mform" id="mform1" accept-charset="utf-8" method="post" action="{$CFG->wwwroot}/admin/user.php" autocomplete="off">
		<div style="display: none;">
			<input type="hidden" value="" name="mform_showadvanced_last">
			<input type="hidden" value="{$USER->sesskey}" name="sesskey">
			<input type="hidden" value="1" name="_qf__user_add_filter_form">
		</div>
		<b>User search:</b>
		<div class="fcontainer clearfix" >
			<div class="fitem advanced fitem_fgroup" id="fgroup_id_email_grp">
				ID Number:
				<select id="id_email_op" name="email_op" style="display:none">
					<option value="0">contains</option>
					<option value="1">doesn't contain</option>
					<option value="2">is equal to</option>
					<option value="3">starts with</option>
					<option value="4">ends with</option>
					<option value="5">is empty</option>
				</select>
				<input type="text" id="id_email" name="email">
			</div>	
			<div class="fitem advanced fitem_fgroup" id="fgroup_id_firstname_grp">
				Firstname:
				<select id="id_firstname_op" name="firstname_op" style="display:none">
					<option value="0">contains</option>
					<option value="1">doesn't contain</option>
					<option value="2">is equal to</option>
					<option value="3">starts with</option>
					<option value="4">ends with</option>
					<option value="5">is empty</option>
				</select>
				<input type="text" id="id_firstname" name="firstname" style="width:160px;">
			</div>
			<div class="fitem advanced fitem_fgroup" id="fgroup_id_lastname_grp">
				Lastname:
				<select id="id_lastname_op" name="lastname_op" style="display:none">
					<option value="0">contains</option>
					<option value="1">doesn't contain</option>
					<option value="2">is equal to</option>
					<option value="3">starts with</option>
					<option value="4">ends with</option>
					<option value="5">is empty</option>
				</select>
				<input type="text" id="id_lastname" name="lastname" style="width:160px;">
			</div>
			<div style="display:none">
				<select id="id_profile_fld" name="profile_fld">
					<option value="0">any field</option>
					<option value="1">turnitinteachercoursecache</option>
				</select>
				<select id="id_profile_op" name="profile_op">
					<option value="0">contains</option>
					<option value="1">doesn't contain</option>
					<option value="2">is equal to</option>
					<option value="3">starts with</option>
					<option value="4">ends with</option>
					<option value="5">is empty</option>
					<option value="6">isn't defined</option>
					<option value="7">is defined</option>
				</select>
				<input type="text" id="id_profile" name="profile">
			</div>
			<input type="submit" id="id_addfilter" value="Go" name="addfilter">
		</div>
	</form>
</div> 	
EOF;

		//if(is_siteadmin()) print "site admin"; else print "no site admin";

		if(is_siteadmin()) {
			$this->content->text   .=  <<<EOF
<div id="quick_ref_block">			
	<!--<a href="https://vle.conel.ac.uk/admin/user.php">Browse list of users</a><br />-->
	<ul style='font-size: 0.9em;'>
		<li><a href="{$CFG->wwwroot}/login/index.php">Login as another user</a></li>
		<?php if(is_siteadmin()) { ?><li><a href="{$CFG->wwwroot}/admin/blocks.php">Manage blocks</a></li><?php } ?>
		<!--li><a href="{$CFG->wwwroot}/admin/stickyblocks.php">Sticky blocks</a></li-->
		<li><a href="{$CFG->wwwroot}/admin/tool/health/index.php">Moodle health check</a></li>
		<li><a href="{$CFG->wwwroot}/course/index.php">All Courses</a></li>
		<li><a href="{$CFG->wwwroot}/blocks/bksb/admin/unmatched_users.php">BKSB – Update Usernames</a></li>
		<!--li><a href="{$CFG->wwwroot}/mod/resource/type/mrcutejr/import.php">MrCuteJr File Importer</a></li-->
		<!--li><a href="{$CFG->wwwroot}/blocks/lpr/actions/reports.php?category_id=53&course_id=19367">E-ilp Stats tool</a></li-->
		<!--li><a href="{$CFG->wwwroot}/stats/index.php?nocache=20110408142940">VLE Stats tool</a></li-->
		<!--li><a href="{$CFG->wwwroot}/course/view.php?id=19367">Surveys</a></li-->
	</ul>
</div> 	
EOF;
		} else {
			$this->content->text   .=  <<<EOF
<div id="quick_ref_block">			
	<ul style='font-size: 0.9em;'>
		<li><a href="{$CFG->wwwroot}/login/index.php">Login as another user</a></li>
		<li><a href="{$CFG->wwwroot}/course/index.php">All Courses</a></li>
	</ul>
</div> 	
EOF;
		}			
/*
		if(is_siteadmin()) {
			$this->content->text   .=  <<<EOF
	<!--<a href="https://vle.conel.ac.uk/admin/user.php">Browse list of users</a><br />-->
	<ul style='font-size: 0.9em;'>
		<li><a href="{$CFG->wwwroot}/login/index.php">Login as another user</a></li>
		<?php if(is_siteadmin()) { ?><li><a href="{$CFG->wwwroot}/admin/blocks.php">Manage blocks</a></li><?php } ?>
		<!--li><a href="{$CFG->wwwroot}/admin/stickyblocks.php">Sticky blocks</a></li-->
		<li><a href="{$CFG->wwwroot}/admin/tool/health/index.php">Moodle health check</a></li>
		<li><a href="{$CFG->wwwroot}/course/index.php">All Courses</a></li>
		<li><a href="{$CFG->wwwroot}/blocks/bksb/admin/unmatched_users.php">BKSB – Update Usernames</a></li>
		<!--li><a href="{$CFG->wwwroot}/mod/resource/type/mrcutejr/import.php">MrCuteJr File Importer</a></li-->
		<!--li><a href="{$CFG->wwwroot}/blocks/lpr/actions/reports.php?category_id=53&course_id=19367">E-ilp Stats tool</a></li-->
		<!--li><a href="{$CFG->wwwroot}/stats/index.php?nocache=20110408142940">VLE Stats tool</a></li-->
		<!--li><a href="{$CFG->wwwroot}/course/view.php?id=19367">Surveys</a></li-->
	</ul>
</div> 	
EOF;
		} else {
			$this->content->text   .=  <<<EOF
	<ul style='font-size: 0.9em;'>
		<li><a href="{$CFG->wwwroot}/login/index.php">Login as another user</a></li>
		<li><a href="{$CFG->wwwroot}/course/index.php">All Courses</a></li>
	</ul>
</div> 	
EOF;			
*/
		    
		$this->content->footer = '';
 
		return $this->content;
    }


    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $DB;

        $config = clone($data);
        // Move embedded files into a proper filearea and adjust HTML links to match
        $config->text = file_save_draft_area_files($data->text['itemid'], $this->context->id, 'block_quick_reference', 'content', 0, array('subdirs'=>true), $data->text['text']);
        $config->format = $data->text['format'];

        parent::instance_config_save($config, $nolongerused);
    }

    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_quick_reference');
        return true;
    }

    function content_is_trusted() {
        global $SCRIPT;

        if (!$context = context::instance_by_id($this->instance->parentcontextid, IGNORE_MISSING)) {
            return false;
        }
        //find out if this block is on the profile page
        if ($context->contextlevel == CONTEXT_USER) {
            if ($SCRIPT === '/my/index.php' || $SCRIPT === '/my/staff.php') {
                // this is exception - page is completely private, nobody else may see content there
                // that is why we allow JS here
                return true;
            } else {
                // no JS on public personal pages, it would be a big security issue
                return false;
            }
        }

        return true;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

    /*
     * Add custom html attributes to aid with theming and styling
     *
     * @return array
     */
    function html_attributes() {
        global $CFG;

        $attributes = parent::html_attributes();

        if (!empty($CFG->block_quick_reference_allowcssclasses)) {
            if (!empty($this->config->classes)) {
                $attributes['class'] .= ' '.$this->config->classes;
            }
        }

        return $attributes;
    }
}
