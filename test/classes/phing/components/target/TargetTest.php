<?php

/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */


require_once 'phing/BuildFileTest.php';

/**
 * UTs for Target component
 *
 * @author Victor Farazdagi <simple.square@gmail.com>
 * @package phing.system
 */
class TargetTest extends BuildFileTest {
    public function setUp() { 
		$this->configureProject(__DIR__."/build.xml");
    }

    public function testHiddenTargets()
    {
        $phingExecutable = PHING_TEST_BASE . '/../bin/phing';
        $buildFile = __DIR__. '/build.xml';
        $cmd = $phingExecutable . ' -l -f ' . $buildFile;
        exec($cmd, $out);
        $out = implode("\n", $out);
        $offset = strpos($out, 'Subtargets:');
        $this->assertFalse(strpos($out, 'HideInListTarget', $offset));
        $this->assertTrue(strpos($out, 'ShowInListTarget', $offset) !== false);
    }
    
    public function testIfConditionHolds() {
    	$this->expectLogContaining('run-if-condition', 'if-condition!');
    }
	
    public function testIfConditionHolds2() {
    	$this->executeTarget('if-condition');
    	$this->assertNotInLogs('if-condition!');
    }
    
    public function testUnlessConditionHolds() {
    	$this->expectLogContaining('unless-condition', 'unless-condition!');
    }
	
    public function testUnlessConditionHolds2() {
    	$this->executeTarget('fail-unless-condition');
    	$this->assertNotInLogs('unless-condition!');
    }
    
}
