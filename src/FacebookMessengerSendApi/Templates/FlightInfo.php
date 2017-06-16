<?php

namespace FacebookMessengerSendApi\Templates;

use FacebookMessengerSendApi\SendAPITransform;

/**
 * Class FlightInfo
 */
class FlightInfo extends SendAPITransform {

  /**
   * Set the connection ID.
   *
   * @param $connection_id
   *   The connection ID.
   *
   * @return $this
   */
  public function connectionId($connection_id) {
    $this->data['connection_id'] = $connection_id;

    return $this;
  }

  /**
   * Set the segment ID.
   *
   * @param $segment_id
   *   The segment ID.
   *
   * @return $this
   */
  public function segmentId($segment_id) {
    $this->data['segment_id'] = $segment_id;

    return $this;
  }

  /**
   * Set the flight number.
   *
   * @param $flight_number
   *   The flight number.
   *
   * @return $this
   */
  public function flightNumber($flight_number) {
    $this->data['flight_number'] = $flight_number;

    return $this;
  }

  /**
   * Set the aircraft type.
   *
   * @param $aircraft_type
   *   The aircraft type.
   *
   * @return $this
   */
  public function aircraftType($aircraft_type) {
    $this->data['aircraft_type'] = $aircraft_type;

    return $this;
  }

  /**
   * Set the departure airport.
   *
   * @param Airport $departure_airport
   *   An airport object.
   *
   * @return $this
   */
  public function departureAirport(Airport $departure_airport) {
    $this->data['departure_airport'] = $departure_airport->getData();

    return $this;
  }

  /**
   * Set hte arrival airport.
   *
   * @param Airport $arrival_airport
   *   The air port object.
   *
   * @return $this
   */
  public function arrivalAirport(Airport $arrival_airport) {
    $this->data['arrival_airport'] = $arrival_airport->getData();

    return $this;
  }

  /**
   * The flight boarding time.
   *
   * @param $boarding_time
   *   The boarding time.
   *
   * @return $this
   *
   * todo: move to object.
   */
  public function boardingTime($boarding_time) {
    $this->data['flight_schedule']['boarding_time'] = $boarding_time;

    return $this;
  }

  /**
   * Set the departure time.
   *
   * @param $departure_time
   *   The departure time.
   *
   * @return $this
   */
  public function departureTime($departure_time) {
    $this->data['flight_schedule']['departure_time'] = $departure_time;

    return $this;
  }

  /**
   * Set the arrival time.
   *
   * @param $arrival_time
   *   The arrival time.
   *
   * @return $this
   */
  public function arrivalTime($arrival_time) {
    $this->data['flight_schedule']['arrival_time'] = $arrival_time;

    return $this;
  }

  /**
   * Set the travel class.
   *
   * @param $travel_class
   *   The travel class.
   *
   * @return $this
   */
  public function travelClass($travel_class) {
    $this->data['travel_class'] = $travel_class;

    return $this;
  }

}
