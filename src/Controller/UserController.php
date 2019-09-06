<?php


namespace App\Controller;


use App\Entity\Courses;
use App\Entity\User;
use App\Form\UserCourseType;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route(path="/dashboard", name="user.dashboard")
     */
    public function getDashboard()
    {
        return $this->render('user/dashboard.html.twig');
    }

    /**
     * @return Response
     * @Route(path="/courses", name="user.courses")
     */
    public function getCourses()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $userCourses = $user->getCourses();
        return $this->render('user/courses/index.html.twig', [
            'userCourses' => $userCourses,
        ]);
    }

    /**
     * @param Request $request
     * @Route(path="/courses/add", name="user.courses.add")
     * @return Response
     */
    public function addCourse(Request $request)
    {
        $courses = $this->getDoctrine()->getRepository(Courses::class)->getRestCourses($this->getUser());

        return $this->render('user/courses/add.html.twig', [
            'courses' => $courses
        ]);
    }

    /**
     * @param Request $request
     * @Route(path="/courses/save", name="user.courses.save")
     * @return Response
     */
    public function saveCourse(Request $request)
    {
        $courseId = $request->get('course_id');
        $course = $this->getDoctrine()->getRepository(Courses::class)->findOneBy([
            'id' => $courseId
        ]);
        if (!$course) {
            return $this->redirectToRoute('user.courses.add');
        }
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $user->addCourse($course);
        $this->getDoctrine()->getRepository(User::class)->saveUser($user);
        return $this->redirectToRoute('user.courses.add');
    }

    /**
     * @param Request $request
     * @param Courses $course
     * @return RedirectResponse
     * @Route(path="/course/delete/{id}", name="user.course.delete")
     */
    public function deleteCourse(Request $request, Courses $course)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $user->removeCourse($course);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user.courses');
    }
}