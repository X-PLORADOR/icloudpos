CREATE

VIEW `v_lista_precios` AS
    SELECT
        `producto`.`producto_id` AS `producto_id`,
        `producto`.`producto_nombre` AS `producto_nombre`,
        `producto`.`producto_codigo_interno` AS `producto_codigo_interno`,
        `producto`.`producto_stockminimo` AS `stock_min`,
        CONCAT('Marca: ',
                `marcas`.`nombre_marca`,
                ', Grupo: ',
                `grupos`.`nombre_grupo`,
                '<br/>',
                'Familia: ',
                `familia`.`nombre_familia`,
                ', Linea: ',
                `lineas`.`nombre_linea`) AS `descripcion`,
        CONCAT(`producto`.`producto_nombre`,
                ' ',
                `grupos`.`nombre_grupo`,
                ' ',
                `proveedor`.`proveedor_nombre`,
                ' ',
                `marcas`.`nombre_marca`,
                ' ',
                `lineas`.`nombre_linea`,
                ' ',
                `familia`.`nombre_familia`) AS `criterio`
    FROM
        (((((`producto`
        LEFT JOIN `marcas` ON ((`producto`.`producto_marca` = `marcas`.`id_marca`)))
        LEFT JOIN `lineas` ON ((`producto`.`producto_linea` = `lineas`.`id_linea`)))
        LEFT JOIN `familia` ON ((`producto`.`producto_familia` = `familia`.`id_familia`)))
        LEFT JOIN `grupos` ON ((`producto`.`produto_grupo` = `grupos`.`id_grupo`)))
        LEFT JOIN `proveedor` ON ((`producto`.`producto_proveedor` = `proveedor`.`id_proveedor`)))
    WHERE
        (`producto`.`producto_estatus` = '1')
    ORDER BY `producto`.`producto_id` , `producto`.`producto_nombre` DESC