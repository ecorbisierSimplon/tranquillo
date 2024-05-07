import { writable, type Writable } from 'svelte/store';

export type GetWritable = string | number | string[] | number[] | boolean;

export function getWritable(value: Writable<GetWritable>): GetWritable {
	let result: GetWritable = '';
	value.subscribe((val) => {
		result = val;
	});
	return result;
}
