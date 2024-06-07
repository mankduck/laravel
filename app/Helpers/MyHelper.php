<?php

if (!function_exists('convert_price')) {
    function convert_price(string $price = '')
    {
        return str_replace('.', '', $price);
    }
}


if (!function_exists('convert_array')) {
    function convert_array($systems = null, $keyword = '', $value = '')
    {
        $temp = [];
        if (is_array($systems)) {
            foreach ($systems as $key => $val) {
                $temp[$val[$keyword]] = $val[$value];
            }
        }

        if (is_object($systems)) {
            foreach ($systems as $key => $val) {
                $temp[$val->{$keyword}] = $val->{$value};
            }
        }

        return $temp;
    }
}



if (!function_exists('renderSystemImage')) {
    function renderSystemImage(string $name = '', $systems = null)
    {
        return '<input type="" name="config[' . $name . ']" value="' . old($name, ($systems[$name] ?? '')) . '"
        class="form-control upload-image" placeholder="" autocomplete="off">';
    }
}

if (!function_exists('renderSystemInput')) {
    function renderSystemInput(string $name = '', $systems = null)
    {
        return '<input type="" name="config[' . $name . ']" value="' . old($name, ($systems[$name] ?? '')) . '"
        class="form-control" placeholder="" autocomplete="off">';
    }
}


if (!function_exists('renderSystemTextarea')) {
    function renderSystemTextarea(string $name = '', $systems = null)
    {
        return '<textarea name="config[' . $name . ']" value="" class="form-control system-textarea">' . old($name, ($systems[$name] ?? '')) . '</textarea>';
    }
}


if (!function_exists('renderSystemLink')) {
    function renderSystemLink(array $item = [], $systems = null)
    {
        return (isset($item['link'])) ? '<a class="system-link" href="' . $item['link']['href'] . '"  target="' . $item['link']['target'] . '">' . $item['link']['text'] . '</a>' : '';
    }
}


if (!function_exists('renderSystemTitle')) {
    function renderSystemTitle(array $item = [], $systems = null)
    {
        return (isset($item['title'])) ? '<span class="system-link text-danger">' . $item['title'] . '</span>' : '';
    }
}


if (!function_exists('renderSystemSelect')) {
    function renderSystemSelect(array $item = [], string $name = '', $systems = null)
    {
        $html = '';
        $html .= '<select name="config[' . $name . ']" class="form-control setupSelect2">';
        foreach ($item['option'] as $key => $val) {
            $html .= '<option ' . (($key == ($systems[$name] ?? '')) ? 'selected' : '') . ' value="' . $key . '">' . $val . '</option>';
        }
        $html .= '</select>';

        return $html;
    }
}


if (!function_exists('write_url')) {
    function write_url(string $canonical = '', bool $fullDomain = true, $suffix = false)
    {

        if (strpos($canonical, 'http') !== false) {
            return $canonical;
        }

        $fullUrl = (($fullDomain === true) ? config('app.url') : '') . $canonical . (($suffix === true) ? config('apps.general.suffix') : '');
        return $fullUrl;
    }
}


if (!function_exists('renderSystemEditor')) {
    function renderSystemEditor(string $name = '', $systems = null)
    {
        return '<textarea id="' . $name . '" name="config[' . $name . ']" data-height="200" value="" class="form-control system-textarea ck-editor">' . old($name, ($systems[$name] ?? '')) . '</textarea>';
    }
}


if (!function_exists('recursive')) {
    function recursive($data, $parentId = 0)
    {
        $temp = [];
        if (!is_null($data) && count($data)) {
            foreach ($data as $key => $val) {
                if ($val->parent_id == $parentId) {
                    $temp[] = [
                        'item' => $val,
                        'children' => recursive($data, $val->id)
                    ];
                }
            }
        }
        return $temp;
    }
}


if (!function_exists('frontend_recursive_menu')) {
    function frontend_recursive_menu($data, $parentId = 0, $type = 'html')
    {
        $html = '';
        if (count($data)) {
            if ($type == 'html') {
                $html = '<ul>';
                foreach ($data as $key => $val) {
                    $name = $val['item']->languages->first()->pivot->name;
                    $canonical = write_url($val['item']->languages->first()->pivot->canonical, false, false);
                    $html .= '<li class=""><a href="' . $canonical . '">' . $name . '</a>';
                    if (count($val['children'])) {
                        $html .= '<ul class="dropdown">';
                        $html .= frontend_recursive_menu($val['children'], $val['item']->parent_id, $type);
                        $html .= "</ul>";
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
                return $html;
            }
        }
        return $data;
    }
}



if (!function_exists('recursive_menu')) {
    function recursive_menu($data)
    {
        $html = '';
        if (count($data)) {
            foreach ($data as $key => $val) {
                $itemId = $val['item']->id;
                $itemName = $val['item']->languages->first()->pivot->name;
                $itemUrl = route('menu.children', ['id' => $itemId]);


                $html .= "<li class='dd-item' data-id='$itemId'>";
                $html .= "<div class='dd-handle'>";
                $html .= "<span class='label label-info'><i class='fa fa-cog'></i></span> $itemName";
                $html .= "</div>";
                $html .= "<a href='$itemUrl' class='create-children-id'> Quản lý menu con </a>";

                if (count($val['children'])) {
                    $html .= "<ol class='dd-list'>";
                    $html .= recursive_menu($val['children']);
                    $html .= "</ol>";

                }

                $html .= "</li>";


            }
        }

        return $html;
    }
}


if (!function_exists('buildMenu')) {
    function buildMenu($menus = null, $parent_id = 0, $prefix = '')
    {
        $output = [];
        $count = 1;

        if (count($menus)) {
            foreach ($menus as $key => $val) {
                if ($val->parent_id == $parent_id) {
                    $val->position = $prefix . $count;
                    $output[] = $val;
                    $output = array_merge($output, buildMenu($menus, $val->id, $val->position . '.'));
                    $count++;
                }
            }
        }

        return $output;
    }
}

if (!function_exists('loadClass')) {
    function loadClass(string $model = '', $folder = 'Repositories', $interface = 'Repository')
    {
        $serviceInterfaceNamespace = '\App\\' . $folder . '\\' . ucfirst($model) . $interface;
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }

        return $serviceInstance;
    }

}

if (!function_exists('convertArrayByKey')) {
    function convertArrayByKey($object = null, $fields = [])
    {
        $temp = [];
        foreach ($object as $key => $val) {
            foreach ($fields as $field) {
                if (is_array($object)) {
                    $temp[$field][] = $val[$field];
                } else {
                    $extract = explode('.', $field);
                    if (count($extract) == 2) {
                        $temp[$extract[0]][] = $val->{$extract[1]}->first()->pivot->{$extract[0]};
                    } else {
                        $temp[$field][] = $val->{$field};
                    }
                }
            }
        }

        return $temp;
    }

}

