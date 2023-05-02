<?php

namespace WPGraphQLAcf\ThirdParty\AcfExtended\FieldType;

class AcfeDateRangePicker {

	/**
	 * @return void
	 */
	public static function register_field_type(): void {

		register_graphql_object_type( 'ACFE_Date_Range', [
			'description' => __( 'A date range made up of a start date and end date', 'wp-graphql-acf' ),
			'fields'      => [
				'startDate' => [
					// @todo: DATETIME Scalar
					'type'        => 'String',
					'description' => __( 'The start date of a date range returned as an RFC 3339 time string', 'wp-graphql-acf' ),
				],
				'endDate'   => [
					// @todo: DATETIME Scalar
					'type'        => 'String',
					'description' => __( 'The start date of a date range RFC 3339 time string', 'wp-graphql-acf' ),
				],
			],
		]);

		register_graphql_acf_field_type( 'acfe_date_range_picker', [
			'graphql_type' => 'ACFE_Date_Range',
			'resolve'      => function ( $root, $args, $context, $info, $field_type, $field_config ) {
				$value = $field_config->resolve_field( $root, $args, $context, $info );
				if ( empty( $value ) ) {
					return null;
				}

				return [
					'startDate' => ! empty( $value['start'] ) ? mysql_to_rfc3339( $value['start'] ) : null,
					'endDate'   => ! empty( $value['end'] ) ? mysql_to_rfc3339( $value['end'] ) : null,
				];
			},
		]);
	}

}
