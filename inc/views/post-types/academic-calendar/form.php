<?php
/** @var WP_Post $post */
global $post;
$items = json_decode( get_post_meta( $post->ID, 'events', true ) );
$items = is_array( $items ) ? $items : array();
?>
<div x-data="{
	items: <?php echo esc_attr( json_encode( $items ) ); ?>,
	addItem() {
		this.items = [...this.items, {date: '', name: ''}]
	},
	removeItem(index) {
		this.items = [
			...this.items.slice(0, index), ...this.items.slice(index + 1)
		]
	},
}" style="margin-top: 20px;">
	<h2><?php _e( 'Data Kegiatan', 'wp-santri' ); ?></h2>
	<input type="hidden" name="events" :value="JSON.stringify(items)">
	<table class="wp-list-table widefat striped">
		<thead>
			<tr>
				<th style="width: 10%;"><?php _e( 'Tanggal', 'wp-santri' ); ?></th>
				<th><?php _e( 'Nama Kegiatan', 'wp-santri' ); ?></th>
				<th style="width: 1%;"></th>
			</tr>
		</thead>
		<tbody>
			<template x-for="(item, index) in items" :key="index">
				<tr>
					<td>
						<input type="date" :name="'item[' + index + '].date'" x-model="item.date">
					</td>
					<td>
						<input class="large-text" type="text" :name="'item[' + index + '].name'" x-model="item.name">
					</td>
					<td>
						<button class="button-link button-link-delete" type="button" @click="removeItem(index)" title="<?php esc_attr_e( 'Hapus', 'wp-santri' ); ?>">
							<span class="dashicons dashicons-trash"></span>
						</button>
					</td>
				</tr>
			</template>
		</tbody>
	</table>
	<button class="button button-large" type="button" @click="addItem()"><?php _e( 'Tambah', 'wp-santri' ); ?></button>
</div>
