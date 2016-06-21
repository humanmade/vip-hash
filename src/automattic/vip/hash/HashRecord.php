<?php

namespace automattic\vip\hash;

class HashRecord {

	private $data;

	function __construct() {
		$this->data = array(
			'date' => time(),
			'username' => '',
			'status' => false,
			'hash' => '',
			'notes' => '',
			'human_note' => '',
		);
	}

	/**
	 * Does this hash already exist in the database?
	 *
	 * @return bool
	 */
	function exists() {
		// @TODO: implement check
		return false;
	}

	/**
	 * @return string
	 */
	public function getNote() {
		return $this->data['note'];
	}

	/**
	 * @param string $note
	 */
	public function setNote( $note ) {
		$this->data['note'] = $note;
	}

	/**
	 * @return string
	 */
	public function getHumanNote() {
		return $this->data['note'];
	}

	/**
	 * @param string $note
	 */
	public function setHumanNote( $note ) {
		$this->data['note'] = $note;
	}

	/**
	 * The date this record was made
	 */
	function getDate() {
		return $this->data['date'];
	}

	function setDate( $date ) {
		$this->data['date'] = $date;
	}

	/**
	 * @return string
	 */
	public function getHash() {
		return $this->data['hash'];
	}

	/**
	 * @param string $hash
	 */
	public function setHash( $hash ) {
		$this->data['hash'] = $hash;
	}

	/**
	 * @return STRING
	 */
	function getStatus() {
		return $this->data['status'];
	}

	/**
	 * @param string $status
	 */
	function setStatus( $status ) {
		$this->data['status'] = $status;
	}

	function setUsername( $username) {
		$this->data['username'] = $username;
	}

	function getUsername() {
		return $this->data['username'];
	}

	/**
	 * Saves this record
	 *
	 * @param DataModel $model
	 *
	 * @return bool
	 * @throws \Exception
	 * @internal param string $folder the location of the hash database with a trailing slash
	 *
	 */
	function save( Pdo_Data_Model $model ) {

		$pdo = $model->getPDO();

		$username = $this->getUsername();
		$hash = $this->getHash();
		$date = $this->getDate();
		$seen = time();
		$status = $this->getStatus();
		$notes = $this->getNote();
		$human_note = $this->getHumanNote();

		$identifier = $hash.'-'.$username.'-'.$date;

		$query = 'INSERT INTO wpcom_vip_hashes VALUES
		( :id, :identifier, :username, :hash, :date, :seen, :status, :notes, :human_note )';
		$sth = $pdo->prepare( $query );
		if ( ! $sth ) {
			$error_info = print_r( $pdo->errorInfo(), true );
			throw new \Exception( $error_info );
			return false;
		}
		$result = $sth->execute( array(
			':id'         => null,
			':identifier' => $identifier,
			':username'   => $username,
			':hash'       => $hash,
			':date'       => $date,
			':seen'       => $seen,
			':status'     => $status,
			':notes'      => $notes,
			':human_note' => $human_note,
		) );

		var_dump( $result );

		if ( ! $result ) {
			$error_info = print_r( $pdo->errorInfo(), true );
			throw new \Exception( $error_info );
		}
		return true;
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param $data
	 */
	public function setData( $data ) {
		$this->data = $data;
	}
}