<?php
/*
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "httpsHealthChecks" collection of methods.
 * Typical usage is:
 *  <code>
 *   $computeService = new Google_Service_Compute(...);
 *   $httpsHealthChecks = $computeService->httpsHealthChecks;
 *  </code>
 */
class Google_Service_Compute_Resource_HttpsHealthChecks extends Google_Service_Resource
{
  /**
   * Deletes the specified HttpsHealthCheck resource. (httpsHealthChecks.delete)
   *
   * @param string $project Project ID for this request.
   * @param string $httpsHealthCheck Name of the HttpsHealthCheck resource to
   * delete.
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function delete($project, $httpsHealthCheck, $optParams = array())
  {
    $params = array('project' => $project, 'httpsHealthCheck' => $httpsHealthCheck);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_Compute_Operation");
  }
  /**
   * Returns the specified HttpsHealthCheck resource. Get a list of available
   * HTTPS health checks by making a list() request. (httpsHealthChecks.get)
   *
   * @param string $project Project ID for this request.
   * @param string $httpsHealthCheck Name of the HttpsHealthCheck resource to
   * return.
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_HttpsHealthCheck
   */
  public function get($project, $httpsHealthCheck, $optParams = array())
  {
    $params = array('project' => $project, 'httpsHealthCheck' => $httpsHealthCheck);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_Compute_HttpsHealthCheck");
  }
  /**
   * Creates a HttpsHealthCheck resource in the specified project using the data
   * included in the request. (httpsHealthChecks.insert)
   *
   * @param string $project Project ID for this request.
   * @param Google_Service_Compute_HttpsHealthCheck $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function insert($project, Google_Service_Compute_HttpsHealthCheck $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('insert', array($params), "Google_Service_Compute_Operation");
  }
  /**
   * Retrieves the list of HttpsHealthCheck resources available to the specified
   * project. (httpsHealthChecks.listHttpsHealthChecks)
   *
   * @param string $project Project ID for this request.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string filter Sets a filter expression for filtering listed
   * resources, in the form filter={expression}. Your {expression} must be in the
   * format: field_name comparison_string literal_string.
   *
   * The field_name is the name of the field you want to compare. Only atomic
   * field types are supported (string, number, boolean). The comparison_string
   * must be either eq (equals) or ne (not equals). The literal_string is the
   * string value to filter to. The literal value must be valid for the type of
   * field you are filtering by (string, number, boolean). For string fields, the
   * literal value is interpreted as a regular expression using RE2 syntax. The
   * literal value must match the entire field.
   *
   * For example, to filter for instances that do not have a name of example-
   * instance, you would use filter=name ne example-instance.
   *
   * You can filter on nested fields. For example, you could filter on instances
   * that have set the scheduling.automaticRestart field to true. Use filtering on
   * nested fields to take advantage of labels to organize and search for results
   * based on label values.
   *
   * To filter on multiple expressions, provide each separate expression within
   * parentheses. For example, (scheduling.automaticRestart eq true) (zone eq us-
   * central1-f). Multiple expressions are treated as AND expressions, meaning
   * that resources must match all expressions to pass the filters.
   * @opt_param string maxResults The maximum number of results per page that
   * should be returned. If the number of available results is larger than
   * maxResults, Compute Engine returns a nextPageToken that can be used to get
   * the next page of results in subsequent list requests.
   * @opt_param string pageToken Specifies a page token to use. Set pageToken to
   * the nextPageToken returned by a previous list request to get the next page of
   * results.
   * @return Google_Service_Compute_HttpsHealthCheckList
   */
  public function listHttpsHealthChecks($project, $optParams = array())
  {
    $params = array('project' => $project);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Compute_HttpsHealthCheckList");
  }
  /**
   * Updates a HttpsHealthCheck resource in the specified project using the data
   * included in the request. This method supports patch semantics.
   * (httpsHealthChecks.patch)
   *
   * @param string $project Project ID for this request.
   * @param string $httpsHealthCheck Name of the HttpsHealthCheck resource to
   * update.
   * @param Google_Service_Compute_HttpsHealthCheck $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function patch($project, $httpsHealthCheck, Google_Service_Compute_HttpsHealthCheck $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'httpsHealthCheck' => $httpsHealthCheck, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_Compute_Operation");
  }
  /**
   * Updates a HttpsHealthCheck resource in the specified project using the data
   * included in the request. (httpsHealthChecks.update)
   *
   * @param string $project Project ID for this request.
   * @param string $httpsHealthCheck Name of the HttpsHealthCheck resource to
   * update.
   * @param Google_Service_Compute_HttpsHealthCheck $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function update($project, $httpsHealthCheck, Google_Service_Compute_HttpsHealthCheck $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'httpsHealthCheck' => $httpsHealthCheck, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('update', array($params), "Google_Service_Compute_Operation");
  }
}
