<?php
/**
 * Copyright (C) 2013 ServMask LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

class Ai1wm_Feedback
{

	/**
	 * Submit customer feedback to ServMask.com
	 *
	 * @param  string  $email   User E-mail
	 * @param  string  $message User Message
	 * @param  integer $terms   User Accept Terms
	 * @return void
	 */
	public function leave_feedback( $email, $message, $terms ) {
		$errors = array();

		// Submit feedback to ServMask
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$errors[] = 'Your email is not valid.';
		} else if ( empty( $message ) ) {
			$errors[] = 'Please enter comments in the text area.';
		} else if ( ! $terms ) {
			$errors[] = 'Please accept feedback term conditions.';
		} else {
			$response = wp_remote_post(
				AI1WM_FEEDBACK_URL,
				array(
					'body' => array(
						'email'               => $email,
						'message'             => $message,
						'export_last_options' => json_encode( get_option( Ai1wm_Export::EXPORT_LAST_OPTIONS, array() ) ),
						'error_handler'       => json_encode( get_option( Ai1wm_Error::ERROR_HANDLER, array() ) ),
						'exception_handler'   => json_encode( get_option( Ai1wm_Error::EXCEPTION_HANDLER, array() ) ),
					),
				)
			);

			if ( is_wp_error( $response ) ) {
				$errors[] = 'Something went wrong: ' .
							$response->get_error_message();
			}
		}

		echo json_encode( array( 'errors' => $errors ) );
		exit;
	}
}
