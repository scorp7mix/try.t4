<?php

return [

    '/admin/blocks'         => '/Admin/Blocks//',
    '/admin/blocks/<1>'     => '/Admin/Blocks/<1>/',
    '/admin/<1>/<2>/<3>'    => '/Admin//Module(module=<1>,controller=<2>,action=<3>)',
    '/admin/<1>/<2>'        => '/Admin//Module(module=<1>,action=<2>)',
    '/admin/<1>'            => '/Admin//Module(module=<1>)',

    '/news/<1>' => '/News//One(id=<1>)',

    '/index' => '///',
    '/pages/<1>/<2>'    => '/Pages/Index/PageByUrl(url=<2>)',
    '/pages/<1>'        => '/Pages/Index/PageByUrl(url=<1>)',

    '/paint/<1>/<2>'       => '//Paint/<1>(id=<2>)',
    '/place/<1>/<2>'       => '//Place/<1>(id=<2>)',
    '/consignment/<1>/<2>'       => '//Consignment/<1>(id=<2>)',
];