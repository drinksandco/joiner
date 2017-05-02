# Joiner Docs

Joiner is a php library to provide serialization and manipulation of the serialized data.

Joiner consists in 3 different and possible steps to result in an output of the provided data 

- `join($arg)` sets the based argument to start joining from.
- `append($key, $arg)` adds to the `$key` key on the final output the following serialized `$arg` argument.
- `filter($key)` 

Imagine we have an array like so `$array = [1,2,3];` and we set it with our `join` like the following `$joiner->join($array);`, whatever we append afterwards, it will be based on this first serialized array.
So having a second string like `$string = "Marcos";` and append it `$joiner->append("name", $string);` will result in 
```
$output = $joiner->execute(); // [0 => 1, 1 => 2, 2 => 3, "name" => "Marcos"]
```
But what if we want do not want any of these results to be shown? We can filter it !

`$joiner->join($array)->append("name", $string)->filter(0)` will result in
```
$output = $joiner->execute(); // [1 => 2, 2 => 3, "name" => "Marcos"]
```


## Examples
- [Primitive Data](primitive_data.md)
- [Object with primitive fields](object_with_primitive_data.md)
- [Object with other objects as fields](object_with_other_objects_as_fields.md)
- [Appending values to nested keys](appending_values_to_nested_keys.md)
- [Filtering nested keys](filtering_nested_keys.md)
