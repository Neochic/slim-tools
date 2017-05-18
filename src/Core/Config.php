<?php

namespace Neochic\SlimTools\Core;

use \Symfony\Component\Yaml\Parser;

class Config {
	protected $parser;
	protected $config = array();

	public function __construct( Parser $parser ) {
		$this->parser = $parser;
	}

	public function load( string $configPath ): array {
		$configs = array( $this->config );
		$this->addConfig( $configs, $configPath );
		$this->config = $this->merge( $configs );

		return $this->config;
	}

	public function get(): array {
		return $this->config;
	}

	protected function addConfig( array &$configs, string $configPath ) {
		$imports    = array();
		$importPath = '';
		$config     = $this->parser->parse( file_get_contents( $configPath ) );

		if ( isset( $config['imports'] ) ) {
			$importPath = dirname( $configPath );
			$imports    = $config['imports'];
			unset( $config['imports'] );
		}

		array_push( $configs, $config );

		foreach ( $imports as $import ) {
			$this->addConfig( $configs, $importPath . '/' . $import );
		}
	}

	protected function merge( array $configs ): array {
		$merged = array();
		foreach ( $configs as $config ) {
			$this->doMerge( $merged, $config );
		}

		return $merged;
	}

	protected function doMerge( array &$target, array &$src ) {
		foreach ( array_keys( $src ) as $key ) {
			if ( ! is_array( $src[ $key ] ) ) {
				continue;
			}

			reset( $src[ $key ] );
			if ( key( $src[ $key ] ) === 0 && $src[ $key ][0] === null ) {
				array_shift( $src[ $key ] );

				if ( isset( $target[ $key ] ) ) {
					unset( $target[ $key ] );
				}
			}

			if ( isset( $target[ $key ] ) && is_array( $target[ $key ] ) ) {
				$this->doMerge( $target[ $key ], $src[ $key ] );
				unset( $src[ $key ] );
			}
		}

		$target = array_merge( $target, $src );
	}
}
